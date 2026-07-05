@extends('layouts.app')

@section('title', 'Events | KUET EMS')

@section('content')
<div class="bg-slate-100 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Explore Events</h1>
                <p class="mt-2 text-slate-500">Find approved KUET events and join the activities you care about.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Back to Dashboard</a>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 mb-8">
            <form method="GET" class="grid gap-4 lg:grid-cols-[1.6fr_1fr_1fr_auto]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events by title or description" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                <select name="club_id" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    <option value="">All clubs</option>
                    @foreach($clubs as $club)
                        <option value="{{ $club->id }}" {{ request('club_id') == $club->id ? 'selected' : '' }}>{{ $club->name }}</option>
                    @endforeach
                </select>
                <select name="event_type" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    <option value="">All types</option>
                    <option value="Workshop" {{ request('event_type') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Seminar" {{ request('event_type') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="Competition" {{ request('event_type') === 'Competition' ? 'selected' : '' }}>Competition</option>
                    <option value="Festival" {{ request('event_type') === 'Festival' ? 'selected' : '' }}>Festival</option>
                    <option value="Meetup" {{ request('event_type') === 'Meetup' ? 'selected' : '' }}>Meetup</option>
                </select>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white shadow-lg shadow-kuet-500/20 hover:bg-kuet-800">Search</button>
            </form>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($events as $event)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-lg transition">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $event->title }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ $event->club->name }} &middot; {{ $event->event_type }}</p>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Approved</span>
                    </div>
                    <p class="mt-4 text-slate-600 line-clamp-3">{{ $event->description }}</p>
                    <div class="mt-5 grid gap-3 text-sm text-slate-500">
                        <div><strong>Venue:</strong> {{ $event->venue }}</div>
                        <div><strong>Date:</strong> {{ $event->event_date }}</div>
                        <div><strong>Seats left:</strong> {{ $event->remaining_seats }}</div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('events.show', $event) }}" class="rounded-2xl bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Details</a>
                        <a href="{{ route('registrations.create', $event) }}" class="rounded-2xl border border-kuet-700 px-4 py-2 text-kuet-700 hover:bg-kuet-100">Register</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl bg-white p-8 text-center shadow-sm border border-slate-200">
                    <p class="text-slate-500">No approved events match your search criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $events->links() }}</div>
    </div>
</div>
@endsection
