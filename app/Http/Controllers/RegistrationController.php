<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $existing = Registration::where('user_id', Auth::id())->where('event_id', $event->id)->exists();
        if ($existing) {
            return back()->withErrors(['registration' => 'You already registered for this event.']);
        }

        if (now()->greaterThan($event->registration_deadline)) {
            return back()->withErrors(['registration' => 'Registration deadline has passed.']);
        }

        $status = 'Confirmed';
        if ($event->remaining_seats <= 0) {
            $status = 'Waitlisted';
        }

        $registration = Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'registration_status' => $status,
            'registration_date' => now()->toDateString(),
            'ticket_number' => 'EV' . now()->format('Ymd') . str_pad((string) (Registration::count() + 1), 4, '0', STR_PAD_LEFT),
        ]);

        if ($status === 'Confirmed') {
            $event->decrement('remaining_seats');
            Ticket::create([
                'registration_id' => $registration->id,
                'qr_code' => 'QR-' . $registration->id,
            ]);
        }

        return back()->with('success', 'Your registration has been recorded.');
    }
}
