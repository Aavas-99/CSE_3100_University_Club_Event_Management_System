@extends('layouts.app')

@section('title', 'Dashboard | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Welcome Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-kuet-500/25">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Welcome back, {{ $user->name }}</h1>
                        <p class="text-slate-500 text-sm mt-0.5 capitalize">{{ $user->role }} Dashboard</p>
                    </div>
                </div>

                <!-- Location & Time Tracker Widget -->
                <div id="location-tracker" class="bg-slate-900 rounded-2xl p-4 shadow-lg min-w-[280px]">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-kuet-500/20 flex items-center justify-center text-kuet-400">
                            <i class="fas fa-location-dot text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-xs">Current Location</h3>
                            <p class="text-slate-400 text-[10px]">Live tracking</p>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loc-loading" class="text-center py-2">
                        <i class="fas fa-circle-notch fa-spin text-kuet-400 text-sm"></i>
                        <p class="text-slate-400 text-[10px] mt-1">Detecting...</p>
                    </div>

                    <!-- Data Display -->
                    <div id="loc-data" class="hidden space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-[11px]"><i class="fas fa-map-marker-alt mr-1"></i> Location</span>
                            <span id="loc-city" class="text-white text-xs font-medium">--</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-[11px]"><i class="fas fa-globe mr-1"></i> Country</span>
                            <span id="loc-country" class="text-white text-xs font-medium">--</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-white/10 pt-2 mt-2">
                            <span class="text-slate-400 text-[11px]"><i class="fas fa-clock mr-1"></i> Time</span>
                            <span id="loc-time" class="text-kuet-400 text-sm font-mono font-bold">--:--:--</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-[11px]"><i class="fas fa-calendar mr-1"></i> Date</span>
                            <span id="loc-date" class="text-white text-[11px] font-medium">--</span>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div id="loc-error" class="hidden text-center py-2">
                        <i class="fas fa-triangle-exclamation text-red-400 text-sm mb-1"></i>
                        <p class="text-red-400 text-[10px]" id="loc-error-msg">Unable to detect</p>
                        <button onclick="retryLocationTracker()" class="mt-1 text-kuet-400 text-[10px] hover:text-kuet-300 underline">
                            Retry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function() {
        let timeInterval = null;
        let currentTimezone = 'UTC';

        document.addEventListener('DOMContentLoaded', initLocationTracker);

        function initLocationTracker() {
            showLoading();

            if ("geolocation" in navigator) {
                requestGeolocation();
            } else {
                useIpFallback();
            }
        }

        function requestGeolocation() {
            showLoading();
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    reverseGeocode(position.coords.latitude, position.coords.longitude);
                },
                (error) => {
                    console.warn('Geolocation error:', error.message);
                    useIpFallback();
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 600000
                }
            );
        }

        async function reverseGeocode(lat, lon) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=10`);
                const data = await response.json();

                const city = data.address?.state_district || data.address?.town || data.address?.village || 'Unknown';
                const country = data.address?.country || 'Unknown';
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                displayLocation(city, country, timezone);
            } catch (err) {
                console.warn('Reverse geocode failed, falling back to IP:', err);
                useIpFallback();
            }
        }

        async function useIpFallback() {
            try {
                const response = await fetch('https://ipwho.is/');
                const data = await response.json();

                if (data.success) {
                    displayLocation(data.city, data.country, data.timezone.id);
                } else {
                    throw new Error('IP lookup failed');
                }
            } catch (err) {
                console.error('IP geolocation failed:', err);
                showError('Unable to detect location. Check connection.');
            }
        }

        function displayLocation(city, country, timezone) {
            currentTimezone = timezone;

            document.getElementById('loc-city').textContent = city;
            document.getElementById('loc-country').textContent = country;

            document.getElementById('loc-loading').classList.add('hidden');
            document.getElementById('loc-error').classList.add('hidden');
            document.getElementById('loc-data').classList.remove('hidden');

            updateDateTime();
            if (timeInterval) clearInterval(timeInterval);
            timeInterval = setInterval(updateDateTime, 1000);
        }

        function updateDateTime() {
            const now = new Date();

            const timeStr = now.toLocaleTimeString('en-US', {
                timeZone: currentTimezone,
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const dateStr = now.toLocaleDateString('en-US', {
                timeZone: currentTimezone,
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            document.getElementById('loc-time').textContent = timeStr;
            document.getElementById('loc-date').textContent = dateStr;
        }

        function showLoading() {
            document.getElementById('loc-loading').classList.remove('hidden');
            document.getElementById('loc-data').classList.add('hidden');
            document.getElementById('loc-error').classList.add('hidden');
        }

        function showError(msg) {
            document.getElementById('loc-loading').classList.add('hidden');
            document.getElementById('loc-data').classList.add('hidden');
            document.getElementById('loc-error').classList.remove('hidden');
            document.getElementById('loc-error-msg').textContent = msg;
        }

        window.retryLocationTracker = initLocationTracker;

        window.addEventListener('beforeunload', () => {
            if (timeInterval) clearInterval(timeInterval);
        });
    })();
    </script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')

        @if($user->role === 'student')
            <!-- Student Dashboard -->
            <!-- Stats Row -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $studentStats = [
                        ['label' => 'Upcoming Events', 'value' => $upcomingEvents->count(), 'icon' => 'fa-calendar-alt', 'color' => 'kuet'],
                        ['label' => 'My Registrations', 'value' => $registrations->count(), 'icon' => 'fa-ticket-alt', 'color' => 'blue'],
                        ['label' => 'Pending', 'value' => $pendingCount, 'icon' => 'fa-clock', 'color' => 'amber'],
                        ['label' => 'Approved', 'value' => $approvedCount, 'icon' => 'fa-check-circle', 'color' => 'emerald'],
                    ];
                @endphp

                @foreach($studentStats as $stat)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all card-lift">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-600">
                                <i class="fas {{ $stat['icon'] }}"></i>
                            </div>
                            <span class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Recommended Events -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-star text-kuet-500"></i>
                            Recommended Events
                        </h2>
                        <a href="{{ route('events.index') }}" class="text-sm font-semibold text-kuet-700 hover:text-kuet-800 flex items-center gap-1">
                            Browse all <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 rounded-md bg-kuet-50 text-kuet-700 text-xs font-bold">{{ $event->event_type }}</span>
                                            <span class="text-xs text-slate-400">{{ $event->club->name }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $event->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                            <span class="flex items-center gap-1"><i class="fas fa-map-marker-alt text-xs"></i> {{ $event->venue }}</span>
                                            <span class="flex items-center gap-1"><i class="fas fa-calendar text-xs"></i> {{ $event->event_date->format('M d') }}</span>
                                            <span class="flex items-center gap-1 {{ $event->remaining_seats > 10 ? 'text-emerald-600' : 'text-amber-600' }}">
                                                <i class="fas fa-chair text-xs"></i> {{ $event->remaining_seats }} left
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('events.show', $event) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 transition-all">
                                            Details
                                        </a>
                                        <!-- Check if student already registered for this event -->
                                        @php
                                            $alreadyRegistered = auth()->user()->registrations()->where('event_id', $event->id)->exists();
                                        @endphp
                                        @if($alreadyRegistered)
                                            @php
                                                $existingReg = auth()->user()->registrations()->where('event_id', $event->id)->first();
                                            @endphp
                                            <span class="px-4 py-2 rounded-xl bg-slate-100 text-slate-400 text-sm font-medium cursor-default flex items-center gap-2">
                                                <i class="fas fa-check"></i> Registered
                                            </span>
                                        @else
                                            <a href="{{ route('registrations.create', $event) }}" class="px-4 py-2 rounded-xl border-2 border-kuet-600 text-kuet-700 text-sm font-medium hover:bg-kuet-50 transition-all">
                                                Register
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                                <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-times text-2xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">No upcoming events</h3>
                                <p class="text-slate-500 text-sm">Check back later for new events.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-history text-kuet-500"></i>
                        My Registrations
                    </h2>
                    
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        @forelse($registrations as $registration)
                            <div class="p-5 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-slate-900 text-sm truncate">{{ $registration->event->title }}</h4>
                                        <p class="text-xs text-slate-500 mt-1">{{ $registration->event->club->name }}</p>
                                    </div>
                                    <span class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-bold
                                        {{ $registration->registration_status === 'Approved' ? 'bg-emerald-50 text-emerald-700' :
                                           ($registration->registration_status === 'Pending' ? 'bg-amber-50 text-amber-700' :
                                           ($registration->registration_status === 'Waitlisted' ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-700')) }}">
                                        {{ $registration->registration_status }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-xs text-slate-400">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $registration->registration_date }}
                                    </p>
                                    <div class="flex items-center gap-3">
                                        @if($registration->registration_status === 'Approved' && $registration->ticket)
                                            <a href="{{ route('tickets.show', $registration->ticket) }}"
                                               class="text-xs font-semibold text-kuet-700 hover:text-kuet-800 flex items-center gap-1 transition-colors">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('tickets.download', $registration->ticket) }}"
                                               class="text-xs font-semibold text-kuet-700 hover:text-kuet-800 flex items-center gap-1 transition-colors">
                                                <i class="fas fa-download"></i> PDF
                                            </a>
                                        @endif
                                        <!-- Cancel button now shown for all registration states -->
                                        <form method="POST" action="{{ route('registrations.cancel', $registration) }}" class="inline" onsubmit="return confirm('Are you sure you want to cancel this registration? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center gap-1 transition-colors">
                                                <i class="fas fa-times-circle"></i> Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="fas fa-ticket-alt text-3xl text-slate-200 mb-3"></i>
                                <p class="text-slate-500 text-sm">No registrations yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @elseif($user->role === 'organizer')
            <!-- Organizer Dashboard -->
            <!-- Stats Row -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $organizerStats = [
                        ['label' => 'Club', 'value' => $club?->name ?? 'N/A', 'icon' => 'fa-building', 'color' => 'kuet', 'isText' => true],
                        ['label' => 'Total Events', 'value' => $eventCount, 'icon' => 'fa-calendar-alt', 'color' => 'blue'],
                        ['label' => 'Pending Regs', 'value' => $pendingRegistrations->count(), 'icon' => 'fa-user-clock', 'color' => 'amber'],
                        ['label' => 'Pending Events', 'value' => $pendingEvents->count(), 'icon' => 'fa-hourglass-half', 'color' => 'purple'],
                    ];
                @endphp

                @foreach($organizerStats as $stat)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all card-lift">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-600">
                                <i class="fas {{ $stat['icon'] }}"></i>
                            </div>
                            @if(!($stat['isText'] ?? false))
                                <span class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</span>
                            @endif
                        </div>
                        @if($stat['isText'] ?? false)
                            <p class="text-lg font-bold text-slate-900 truncate">{{ $stat['value'] }}</p>
                        @endif
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Pending Registrations -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-user-clock text-amber-500"></i>
                            Pending Registrations
                        </h2>
                        <a href="{{ route('events.create') }}" class="px-4 py-2 rounded-xl bg-kuet-600 text-white text-sm font-medium hover:bg-kuet-700 transition-all flex items-center gap-2">
                            <i class="fas fa-plus text-xs"></i> Create Event
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        @forelse($pendingRegistrations as $registration)
                            <div class="p-5 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-3 min-w-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                            {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-semibold text-slate-900 text-sm">{{ $registration->user->name }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Event: {{ $registration->event->title }}</p>
                                            <p class="text-xs text-slate-400">{{ $registration->user->department ?? 'No dept' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 flex-shrink-0">
                                        <form method="POST" action="{{ route('registrations.approve', $registration) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center transition-all" title="Approve">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('registrations.reject', $registration) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-all" title="Reject">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="fas fa-check-circle text-3xl text-emerald-200 mb-3"></i>
                                <p class="text-slate-500 text-sm">No pending registrations</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pending Events -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-hourglass-half text-purple-500"></i>
                        Pending Event Approvals
                    </h2>

                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        @forelse($pendingEvents as $event)
                            <div class="p-5 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                                <h4 class="font-semibold text-slate-900 text-sm mb-1">{{ $event->title }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ Str::limit($event->description, 100) }}</p>
                                <div class="flex items-center gap-3 text-xs text-slate-400">
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $event->event_date->format('M d') }}</span>
                                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->venue }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="fas fa-rocket text-3xl text-slate-200 mb-3"></i>
                                <p class="text-slate-500 text-sm">No pending events</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @else
            <!-- Admin Dashboard -->
            <!-- Stats Row -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $adminStats = [
                        ['label' => 'Total Users', 'value' => $usersCount, 'icon' => 'fa-users', 'color' => 'blue'],
                        ['label' => 'Clubs', 'value' => $clubsCount, 'icon' => 'fa-building', 'color' => 'kuet'],
                        ['label' => 'Events', 'value' => $eventsCount, 'icon' => 'fa-calendar-alt', 'color' => 'purple'],
                        ['label' => 'Registrations', 'value' => $registrations, 'icon' => 'fa-ticket-alt', 'color' => 'emerald'],
                    ];
                @endphp

                @foreach($adminStats as $stat)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all card-lift">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-600">
                                <i class="fas {{ $stat['icon'] }}"></i>
                            </div>
                            <span class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Pending Approvals -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-amber-500"></i>
                            Pending Event Approvals
                        </h2>
                        <a href="{{ route('admin.events.pending') }}" class="text-sm font-semibold text-kuet-700 hover:text-kuet-800 flex items-center gap-1">
                            View all <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($pendingEvents as $event)
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-xs font-bold">Pending</span>
                                            <span class="text-xs text-slate-400">{{ $event->club->name }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $event->title }}</h3>
                                        <p class="text-sm text-slate-500 mt-1">By {{ $event->club->organizer->name }} • {{ $event->event_type }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition-all flex items-center gap-2">
                                                <i class="fas fa-check text-xs"></i> Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 text-sm font-medium hover:bg-red-100 transition-all flex items-center gap-2">
                                                <i class="fas fa-times text-xs"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                                    <i class="fas fa-check-double text-2xl text-emerald-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">All caught up!</h3>
                                <p class="text-slate-500 text-sm">No pending event approvals.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-chart-line text-kuet-500"></i>
                        Recent Activity
                    </h2>

                    <!-- Latest Users -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Latest Users</h3>
                        </div>
                        @forelse($users as $userItem)
                            <div class="px-5 py-3 border-b border-slate-50 last:border-0 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $userItem->name }}</p>
                                        <p class="text-xs text-slate-500 capitalize">{{ $userItem->role }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400">{{ $userItem->created_at->format('M d') }}</span>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-500 text-sm">No users yet</div>
                        @endforelse
                    </div>

                    <!-- Latest Clubs -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Latest Clubs</h3>
                        </div>
                        @forelse($clubs as $clubItem)
                            <div class="px-5 py-3 border-b border-slate-50 last:border-0 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $clubItem->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $clubItem->events_count }} events</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ $clubItem->created_at->format('M d') }}</span>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-500 text-sm">No clubs yet</div>
                        @endforelse
                    </div>

                    <!-- Latest Events -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Latest Events</h3>
                        </div>
                        @forelse($events as $eventItem)
                            <div class="px-5 py-3 border-b border-slate-50 last:border-0 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $eventItem->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $eventItem->club->name }}</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ $eventItem->event_date->format('M d') }}</span>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-500 text-sm">No events yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection