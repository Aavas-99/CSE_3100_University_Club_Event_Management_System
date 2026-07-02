<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('club')->latest()->paginate(6);

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('club.organizer');

        return view('events.show', compact('event'));
    }

    public function create()
    {
        $clubs = Club::all();

        return view('events.create', compact('clubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'registration_deadline' => ['required', 'date'],
            'seat_limit' => ['required', 'integer', 'min:1'],
            'event_type' => ['required', 'string', 'max:100'],
        ]);

        $data['remaining_seats'] = $data['seat_limit'];
        $data['status'] = 'Upcoming';

        Event::create($data);

        return redirect('/events')->with('success', 'Event created successfully.');
    }
}
