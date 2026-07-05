<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $clubs = Club::orderBy('name')->get();

        $events = Event::with('club')
            ->where('status', 'Approved')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($sub) use ($request) {
                    $sub->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('club_id'), function ($query) use ($request) {
                $query->where('club_id', $request->club_id);
            })
            ->when($request->filled('event_type'), function ($query) use ($request) {
                $query->where('event_type', $request->event_type);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('events.index', compact('events', 'clubs'));
    }

    public function show(Event $event)
    {
        $event->load('club.organizer');

        return view('events.show', compact('event'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('events.index');
        }

        $club = $user->organizerClub;

        if (!$club) {
            return redirect()->route('dashboard')->withErrors(['club' => 'Your club profile must be created before adding events.']);
        }

        return view('events.create', compact('club'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('events.index');
        }

        $club = $user->organizerClub;
        if (!$club) {
            return redirect()->route('dashboard')->withErrors(['club' => 'Your club profile must be created before adding events.']);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'registration_deadline' => ['required', 'date', 'before_or_equal:event_date'],
            'seat_limit' => ['required', 'integer', 'min:1'],
            'event_type' => ['required', 'string', 'max:100'],
        ]);

        $data['club_id'] = $club->id;
        $data['remaining_seats'] = $data['seat_limit'];
        $data['status'] = 'Pending';

        Event::create($data);

        return redirect()->route('dashboard')->with('success', 'Your event has been submitted for admin approval.');
    }

    public function pendingApproval()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('login.admin');
        }

        $events = Event::with('club.organizer')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(8);

        return view('admin.events.pending', compact('events'));
    }

    public function approve(Event $event)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('login.admin');
        }

        $event->status = 'Approved';
        $event->save();

        return back()->with('success', 'Event approved successfully.');
    }

    public function reject(Event $event)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('login.admin');
        }

        $event->status = 'Rejected';
        $event->save();

        return back()->with('success', 'Event rejected successfully.');
    }
}
