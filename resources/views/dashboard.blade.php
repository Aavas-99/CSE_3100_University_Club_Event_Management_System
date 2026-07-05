@extends('layouts.app')

@section('title', 'Dashboard | KUET EMS')

@section('content')
<div class="bg-slate-100 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        @include('partials.flash')
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Hello, {{ $user->name }}</h1>
                <p class="mt-2 text-slate-500">Welcome back to your KUET EMS dashboard.</p>
            </div>
        </div>

        @if($user->role === 'student')
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 mb-8">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Upcoming Events</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $upcomingEvents->count() }}</p>
                    <p class="mt-2 text-sm text-slate-500">Live events available to join.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Registrations</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $registrations->count() }}</p>
                    <p class="mt-2 text-sm text-slate-500">Recent event applications.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Pending Requests</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $pendingCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Waiting for organizer review.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Approved</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $approvedCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Confirmed registrations.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Recommended Events</h2>
                            <p class="text-sm text-slate-500">Explore approved events and register quickly.</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="text-kuet-700 font-semibold">Browse all</a>
                    </div>
                    <div class="grid gap-4">
                        @forelse($upcomingEvents as $event)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $event->title }}</h3>
                                        <p class="text-sm text-slate-600">{{ $event->club->name }} &middot; {{ $event->event_type }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-sm text-slate-600">{{ $event->event_date }}</span>
                                </div>
                                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-600">
                                    <span>Venue: {{ $event->venue }}</span>
                                    <span>Seats left: {{ $event->remaining_seats }}</span>
                                </div>
                                <div class="mt-4 flex gap-3">
                                    <a href="{{ route('events.show', $event) }}" class="rounded-2xl bg-kuet-700 px-4 py-2 text-white hover:bg-kuet-800">View details</a>
                                    <a href="{{ route('registrations.create', $event) }}" class="rounded-2xl border border-kuet-700 px-4 py-2 text-kuet-700 hover:bg-kuet-100">Register</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500">No approved events are available right now.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Recent Registrations</h2>
                    <div class="space-y-4">
                        @forelse($registrations as $registration)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <h3 class="font-semibold text-slate-900">{{ $registration->event->title }}</h3>
                                        <p class="text-sm text-slate-600">{{ $registration->event->club->name }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $registration->registration_status === 'Approved' ? 'bg-emerald-100 text-emerald-700' : ($registration->registration_status === 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                        {{ $registration->registration_status }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm text-slate-600">Registered on {{ $registration->registration_date }}</p>
                            </div>
                        @empty
                            <p class="text-slate-500">You have not registered for any events yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @elseif($user->role === 'organizer')
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 mb-8">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Club</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $club?->name ?? 'Not assigned' }}</p>
                    <p class="mt-2 text-sm text-slate-500">Your managed club.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Events</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $eventCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Events created by your club.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Pending registrations</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $pendingRegistrations->count() }}</p>
                    <p class="mt-2 text-sm text-slate-500">Awaiting approval.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Pending events</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $pendingEvents->count() }}</p>
                    <p class="mt-2 text-sm text-slate-500">Awaiting admin review.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Pending Registrations</h2>
                            <p class="text-sm text-slate-500">Review student requests for your club events.</p>
                        </div>
                        <a href="{{ route('events.create') }}" class="rounded-2xl bg-kuet-700 px-4 py-2 text-white hover:bg-kuet-800">Create Event</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($pendingRegistrations as $registration)
                            <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="font-semibold text-slate-900">{{ $registration->user->name }}</h3>
                                        <p class="text-sm text-slate-600">Event: {{ $registration->event->title }}</p>
                                        <p class="text-sm text-slate-600">Department: {{ $registration->user->department ?? 'Not set' }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('registrations.approve', $registration) }}">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-green-700 px-4 py-2 text-white hover:bg-green-800">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('registrations.reject', $registration) }}">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-white hover:bg-red-700">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500">No student registration requests are waiting.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900 mb-6">Pending Event Requests</h2>
                    <div class="space-y-4">
                        @forelse($pendingEvents as $event)
                            <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                <h3 class="font-semibold text-slate-900">{{ $event->title }}</h3>
                                <p class="mt-2 text-sm text-slate-600">{{ Str::limit($event->description, 120) }}</p>
                                <p class="mt-3 text-sm text-slate-500">Date: {{ $event->event_date }} &middot; Venue: {{ $event->venue }}</p>
                            </div>
                        @empty
                            <p class="text-slate-500">No event requests submitted yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-4 mb-8">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Users</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $usersCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total registered members.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Clubs</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $clubsCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Active campus clubs.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Events</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $eventsCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Events created across the platform.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Registrations</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $registrations }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total event activity recorded.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Pending Event Approvals</h2>
                            <p class="text-sm text-slate-500">Review and publish club events after verifying details.</p>
                        </div>
                        <a href="{{ route('admin.events.pending') }}" class="text-kuet-700 font-semibold">View all pending</a>
                    </div>

                    <div class="grid gap-4">
                        @forelse($pendingEvents as $event)
                            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $event->title }}</h3>
                                        <p class="text-sm text-slate-600">{{ $event->club->name }} &middot; {{ $event->event_type }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-green-700 px-4 py-2 text-white hover:bg-green-800">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                            @csrf
                                            <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-white hover:bg-red-700">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-3xl bg-white p-8 border border-slate-200 text-slate-500">
                                There are no pending event approval requests.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900 mb-6">Recent Activity</h2>
                    <div class="space-y-5">
                        <div>
                            <h3 class="text-sm uppercase tracking-[0.2em] text-slate-400">Latest Users</h3>
                            <div class="space-y-3 mt-4">
                                @forelse($users as $userItem)
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $userItem->name }}</p>
                                            <p class="text-sm text-slate-500">{{ ucfirst($userItem->role) }}</p>
                                        </div>
                                        <span class="text-sm text-slate-500">{{ $userItem->created_at->format('M d') }}</span>
                                    </div>
                                @empty
                                    <p class="text-slate-500">No recent user signups yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm uppercase tracking-[0.2em] text-slate-400">Latest Clubs</h3>
                            <div class="space-y-3 mt-4">
                                @forelse($clubs as $clubItem)
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $clubItem->name }}</p>
                                            <p class="text-sm text-slate-500">{{ $clubItem->events_count }} events</p>
                                        </div>
                                        <span class="text-sm text-slate-500">{{ $clubItem->created_at->format('M d') }}</span>
                                    </div>
                                @empty
                                    <p class="text-slate-500">No clubs have been created yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm uppercase tracking-[0.2em] text-slate-400">Latest Events</h3>
                            <div class="space-y-3 mt-4">
                                @forelse($events as $eventItem)
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $eventItem->title }}</p>
                                            <p class="text-sm text-slate-500">{{ $eventItem->club->name }}</p>
                                        </div>
                                        <span class="text-sm text-slate-500">{{ $eventItem->event_date }}</span>
                                    </div>
                                @empty
                                    <p class="text-slate-500">No events are available yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
