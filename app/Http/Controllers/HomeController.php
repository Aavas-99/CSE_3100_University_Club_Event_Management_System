<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $eventsHosted = Event::where('status', 'Approved')->count();
        $activeClubs = Club::count();
        $students = User::where('role', 'student')->count();

        $upcomingEvents = Event::with('club')
            ->where('status', 'Approved')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        return view('home.index', compact('eventsHosted', 'activeClubs', 'students', 'upcomingEvents'));
    }
}
