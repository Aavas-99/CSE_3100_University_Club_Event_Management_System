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

            return view('dashboard', compact('user', 'club', 'eventCount', 'pendingRegistrations', 'pendingEvents'));
        }

        $pendingEvents = Event::where('status', 'Pending')->with('club.organizer')->latest()->take(8)->get();
        $users = User::latest()->take(8)->get();
        $clubs = Club::withCount('events')->latest()->take(8)->get();
        $events = Event::latest()->take(8)->get();
        $usersCount = User::count();
        $clubsCount = Club::count();
        $eventsCount = Event::count();
        $registrations = Registration::count();

        return view('dashboard', compact('user', 'pendingEvents', 'users', 'clubs', 'events', 'usersCount', 'clubsCount', 'eventsCount', 'registrations'));
    }
}
