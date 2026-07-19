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

        // Build base query with session-based status filtering
        $query = Event::with('club');

        // Session/cookie-based status logic - shows different statuses based on logged-in user role
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Admin sees all events with their real statuses
                // No additional status filter applied by default
            } elseif ($user->role === 'organizer') {
                // Organizer sees approved events + their own club's pending/rejected events
                $clubId = $user->organizerClub?->id;
                if ($clubId) {
                    $query->where(function ($q) use ($clubId) {
                        $q->where('status', 'Approved')
                          ->orWhere(function ($sq) use ($clubId) {
                              $sq->where('club_id', $clubId);
                          });
                    });
                } else {
                    $query->where('status', 'Approved');
                }
            } else {
                // Students and others only see approved events
                $query->where('status', 'Approved');
            }
        } else {
            // Guests only see approved events
            $query->where('status', 'Approved');
        }

        // Status filter from request (for admin/organizer session views)
        if ($request->filled('status_filter')) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role === 'admin') {
                    if ($request->status_filter === 'pending') {
                        $query->where('status', 'Pending');
                    } elseif ($request->status_filter === 'approved') {
                        $query->where('status', 'Approved');
                    }
                    // 'all' shows everything (no extra filter)
                } elseif ($user->role === 'organizer' && $request->status_filter === 'my_pending') {
                    $query->where('club_id', $user->organizerClub?->id)
                          ->where('status', 'Pending');
                }
            }
        }

        // Existing filters
        $query->when($request->filled('search'), function ($query) use ($request) {
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
        ->when($request->filled('time_filter'), function ($query) use ($request) {
            $now = now();
            $currentDate = $now->toDateString();
            $currentTime = $now->toTimeString();

            if ($request->time_filter === 'upcoming') {
                $query->where(function ($q) use ($currentDate, $currentTime) {
                    $q->where('event_date', '>', $currentDate)
                      ->orWhere(function($sq) use ($currentDate, $currentTime) {
                          $sq->where('event_date', '=', $currentDate)
                             ->where('start_time', '>', $currentTime);
                      });
                });
            } elseif ($request->time_filter === 'ongoing') {
                $query->where('event_date', '=', $currentDate)
                      ->where('start_time', '<=', $currentTime)
                      ->where('end_time', '>=', $currentTime);
            } elseif ($request->time_filter === 'ended') {
                $query->where(function ($q) use ($currentDate, $currentTime) {
                    $q->where('event_date', '<', $currentDate)
                      ->orWhere(function($sq) use ($currentDate, $currentTime) {
                          $sq->where('event_date', '=', $currentDate)
                             ->where('end_time', '<', $currentTime);
                      });
                });
            }
        });

        // Sorting
        if ($request->filled('sort')) {
            if ($request->sort === 'date') {
                $query->orderBy('event_date', 'asc');
            } elseif ($request->sort === 'seats') {
                $query->orderBy('remaining_seats', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $events = $query->paginate(6)->withQueryString();

        // Prepare calendar events data for smart calendar view
        $calendarEvents = [];
        if ($request->get('view') === 'calendar') {
            // Clone the main query before it was paginated (but it has orders, which is fine)
            // so that all filters (status, search, club) apply to the calendar as well.
            $calendarQuery = clone $query;
            $allCalendarEvents = $calendarQuery->get();

            foreach ($allCalendarEvents as $evt) {
                $calendarEvents[] = [
                    'id' => $evt->id,
                    'title' => $evt->title,
                    'start' => $evt->event_date->format('Y-m-d') . 'T' . $evt->start_time,
                    'end' => $evt->event_date->format('Y-m-d') . 'T' . $evt->end_time,
                    'url' => route('events.show', $evt),
                    'club' => $evt->club->name,
                    'venue' => $evt->venue,
                    'backgroundColor' => $evt->status === 'Approved' ? '#16a34a' : '#f59e0b',
                    'borderColor' => $evt->status === 'Approved' ? '#15803d' : '#d97706',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'url' => route('events.show', $evt),
                        'club' => $evt->club->name,
                        'venue' => $evt->venue,
                        'status' => $evt->status,
                    ],
                ];
            }
        }

        return view('events.index', compact('events', 'clubs', 'calendarEvents'));
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
