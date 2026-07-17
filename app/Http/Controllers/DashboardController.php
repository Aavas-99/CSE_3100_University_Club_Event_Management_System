<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if ($user->role === 'student') {
            $upcomingEvents = Event::where('status', 'Approved')
                ->where('event_date', '>=', now()->toDateString())
                ->latest()
                ->take(5)
                ->get();

            $registrations = $user->registrations()->with('event.club')->latest()->take(6)->get();
            $pendingCount = $user->registrations()->where('registration_status', 'Pending')->count();
            $approvedCount = $user->registrations()->where('registration_status', 'Approved')->count();

            return view('dashboard', compact('user', 'upcomingEvents', 'registrations', 'pendingCount', 'approvedCount'));
        }

        if ($user->role === 'organizer') {
            $club = $user->organizerClub;
            $eventCount = $club ? $club->events()->count() : 0;
            $pendingRegistrations = Registration::whereHas('event', function ($query) use ($user) {
                $query->where('club_id', $user->organizerClub?->id);
            })->where('registration_status', 'Pending')->with('event', 'user')->latest()->take(8)->get();

            $pendingEvents = Event::where('club_id', $user->organizerClub?->id)
                ->where('status', 'Pending')
                ->latest()
                ->take(8)
                ->get();

            $allEvents = $club ? $club->events()->with(['registrations.user'])->latest()->get() : collect();

            return view('dashboard', compact('user', 'club', 'eventCount', 'pendingRegistrations', 'pendingEvents', 'allEvents'));
        }

        $tab = $request->get('tab', 'overview');

        if ($tab === 'overview') {
            $pendingEvents = Event::where('status', 'Pending')->with('club.organizer')->latest()->take(8)->get();
            $users = User::where('role', '!=', 'admin')->latest()->take(8)->get();
            $clubs = Club::withCount('events')->latest()->take(8)->get();
            $events = Event::latest()->take(8)->get();
            $usersCount = User::count();
            $clubsCount = Club::count();
            $eventsCount = Event::count();
            $registrations = Registration::count();

            return view('dashboard', compact('user', 'tab', 'pendingEvents', 'users', 'clubs', 'events', 'usersCount', 'clubsCount', 'eventsCount', 'registrations'));
        }

        if ($tab === 'clubs') {
            $query = Club::withCount('events')->with('organizer');
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            }
            
            $sort = $request->get('sort', 'latest');
            if ($sort === 'oldest') {
                $query->oldest();
            } elseif ($sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->latest();
            }
            
            $clubsList = $query->paginate(10)->withQueryString();
            return view('dashboard', compact('user', 'tab', 'clubsList'));
        }

        if ($tab === 'students') {
            $query = User::where('role', 'student');
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%");
                });
            }

            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }
            
            $sort = $request->get('sort', 'latest');
            if ($sort === 'oldest') {
                $query->oldest();
            } elseif ($sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->latest();
            }
            
            $studentsList = $query->paginate(10)->withQueryString();
            $departments = User::where('role', 'student')->whereNotNull('department')->where('department', '!=', '')->distinct()->pluck('department');
            
            return view('dashboard', compact('user', 'tab', 'studentsList', 'departments'));
        }

        if ($tab === 'events') {
            $query = Event::with('club');
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('venue', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('type')) {
                $query->where('event_type', $request->type);
            }
            if ($request->filled('club_id')) {
                $query->where('club_id', $request->club_id);
            }
            
            $sort = $request->get('sort', 'latest');
            if ($sort === 'oldest') {
                $query->oldest();
            } elseif ($sort === 'date_asc') {
                $query->orderBy('event_date', 'asc');
            } elseif ($sort === 'date_desc') {
                $query->orderBy('event_date', 'desc');
            } else {
                $query->latest();
            }
            
            $eventsList = $query->paginate(10)->withQueryString();
            $filterClubs = Club::orderBy('name')->get();
            return view('dashboard', compact('user', 'tab', 'eventsList', 'filterClubs'));
        }
    }
}
