<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function create(Event $event)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'student') {
            return redirect()->route('login.student');
        }

        if ($event->status !== 'Approved') {
            return redirect()->route('events.index')->withErrors(['event' => 'This event is not open for registration.']);
        }

        $existing = Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists();
        if ($existing) {
            return redirect()->route('events.show', $event)->withErrors(['registration' => 'You have already requested registration for this event.']);
        }

        return view('registrations.create', compact('event', 'user'));
    }

    public function store(Request $request, Event $event)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            return redirect()->route('login.student');
        }

        if ($event->status !== 'Approved') {
            return redirect()->route('events.index')->withErrors(['event' => 'This event is not open for registration.']);
        }

        $existing = Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists();
        if ($existing) {
            return back()->withErrors(['registration' => 'You have already requested registration for this event.']);
        }

        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'department' => ['required', 'string', 'max:100'],
        ]);

        $user->update([
            'phone' => $request->phone,
            'department' => $request->department,
        ]);

        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'registration_status' => 'Pending',
            'registration_date' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Your registration request has been submitted for organizer review.');
    }

    public function approve(Registration $registration)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('login.organizer');
        }

        $club = $user->organizerClub;
        if (!$club || $registration->event->club_id !== $club->id) {
            return back()->withErrors(['authorization' => 'You do not have permission to approve this registration.']);
        }

        if ($registration->registration_status !== 'Pending') {
            return back()->withErrors(['registration' => 'Only pending requests can be updated.']);
        }

        if ($registration->event->remaining_seats > 0) {
            $registration->registration_status = 'Approved';
            $registration->ticket_number = 'EV' . now()->format('Ymd') . str_pad((string) ($registration->id), 4, '0', STR_PAD_LEFT);
            $registration->save();

            Ticket::create([
                'registration_id' => $registration->id,
                'qr_code' => 'QR-' . $registration->id,
                'issued_at' => now(),
            ]);

            $registration->event->decrement('remaining_seats');
        } else {
            $registration->registration_status = 'Waitlisted';
            $registration->save();
        }

        return back()->with('success', 'Registration request processed successfully.');
    }

    public function reject(Registration $registration)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('login.organizer');
        }

        $club = $user->organizerClub;
        if (!$club || $registration->event->club_id !== $club->id) {
            return back()->withErrors(['authorization' => 'You do not have permission to reject this registration.']);
        }

        if ($registration->registration_status !== 'Pending') {
            return back()->withErrors(['registration' => 'Only pending requests can be updated.']);
        }

        $registration->registration_status = 'Rejected';
        $registration->save();

        return back()->with('success', 'Registration request rejected.');
    }
}
