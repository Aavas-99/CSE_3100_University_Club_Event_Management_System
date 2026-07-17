@extends('layouts.app')

@section('title', 'Events | KUET EMS')

@push('styles')
    <!-- FullCalendar v6 CSS is auto-injected by JS, but we add custom styling for the container -->
    <style>
        .fc {
            font-family: 'Inter', system-ui, sans-serif !important;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .fc .fc-button {
            background: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 500 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.75rem !important;
            text-transform: capitalize !important;
            box-shadow: none !important;
        }
        .fc .fc-button:hover {
            background: #e2e8f0 !important;
            color: #0f172a !important;
        }
        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: #16a34a !important;
            border-color: #16a34a !important;
            color: #fff !important;
        }
        .fc .fc-button:focus {
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2) !important;
        }
        .fc th {
            padding: 0.75rem 0 !important;
            font-weight: 600 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.05em !important;
        }
        .fc td {
            border-color: #e2e8f0 !important;
        }
        .fc .fc-daygrid-day-number {
            color: #475569 !important;
            font-weight: 500 !important;
            padding: 0.5rem !important;
        }
        .fc .fc-daygrid-day.fc-day-today {
            background: #f0fdf4 !important;
        }
        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: #16a34a !important;
            color: #fff !important;
            border-radius: 50% !important;
            width: 28px !important;
            height: 28px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .fc-event {
            border-radius: 6px !important;
            padding: 2px 6px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            border: none !important;
            cursor: pointer !important;
        }
        .fc-event:hover {
            opacity: 0.9 !important;
            transform: translateY(-1px) !important;
        }
        .fc .fc-list-event-dot {
            display: none !important;
        }
        .fc .fc-list-empty {
            padding: 3rem !important;
            background: #f8fafc !important;
            border-radius: 1rem !important;
        }
        .fc .fc-scrollgrid {
            border-radius: 1rem !important;
            border: 1px solid #e2e8f0 !important;
        }
        .fc .fc-scroller {
            overflow: hidden auto !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding: 0.5rem 0 !important;
        }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Explore Events</h1>
                    <p class="mt-2 text-slate-500">Find approved KUET events and join the activities you care about.</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')

        <!-- View Mode Toggle - Session-based view switching -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-700">View Mode:</span>
                    <div class="inline-flex bg-slate-100 rounded-xl p-1">
                        <a href="{{ route('events.index', array_merge(request()->except(['view']), ['view' => 'grid'])) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('view', 'grid') === 'grid' ? 'bg-white text-kuet-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            <i class="fas fa-th-large mr-1.5"></i>Grid
                        </a>
                        <a href="{{ route('events.index', array_merge(request()->except(['view']), ['view' => 'calendar'])) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('view') === 'calendar' ? 'bg-white text-kuet-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            <i class="fas fa-calendar mr-1.5"></i>Calendar
                        </a>
                        @auth
                            <a href="{{ route('events.index', array_merge(request()->except(['view']), ['view' => 'my'])) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('view') === 'my' ? 'bg-white text-kuet-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                                <i class="fas fa-user mr-1.5"></i>My Events
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Session-based status filter for logged-in users -->
                @auth
                    @if(auth()->user()->role === 'organizer')
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">Show:</span>
                            <a href="{{ route('events.index', array_merge(request()->except(['status_filter']), ['status_filter' => 'all'])) }}"
                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ request('status_filter', 'all') === 'all' ? 'bg-kuet-100 text-kuet-700' : 'text-slate-500 hover:bg-slate-100' }}">
                                All
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['status_filter']), ['status_filter' => 'my_pending'])) }}"
                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ request('status_filter') === 'my_pending' ? 'bg-amber-100 text-amber-700' : 'text-slate-500 hover:bg-slate-100' }}">
                                My Pending
                            </a>
                        </div>
                    @elseif(auth()->user()->role === 'admin')
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">Show:</span>
                            <a href="{{ route('events.index', array_merge(request()->except(['status_filter']), ['status_filter' => 'all'])) }}"
                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ request('status_filter', 'all') === 'all' ? 'bg-kuet-100 text-kuet-700' : 'text-slate-500 hover:bg-slate-100' }}">
                                All
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['status_filter']), ['status_filter' => 'pending'])) }}"
                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ request('status_filter') === 'pending' ? 'bg-amber-100 text-amber-700' : 'text-slate-500 hover:bg-slate-100' }}">
                                Pending
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['status_filter']), ['status_filter' => 'approved'])) }}"
                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ request('status_filter') === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'text-slate-500 hover:bg-slate-100' }}">
                                Approved
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Search & Filter Panel (hidden in calendar view) -->
        @if(request('view', 'grid') !== 'calendar')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <!-- Preserve view mode -->
                <input type="hidden" name="view" value="{{ request('view', 'grid') }}">
                @if(request('status_filter'))
                    <input type="hidden" name="status_filter" value="{{ request('status_filter') }}">
                @endif

                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search events by title or description..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                </div>

                <div class="flex gap-3 flex-col sm:flex-row">
                    <div class="relative">
                        <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <select name="club_id" class="pl-10 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus appearance-none cursor-pointer min-w-[180px]">
                            <option value="">All Clubs</option>
                            @foreach($clubs as $club)
                                <option value="{{ $club->id }}" {{ request('club_id') == $club->id ? 'selected' : '' }}>
                                    {{ $club->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <select name="event_type" class="pl-10 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus appearance-none cursor-pointer min-w-[160px]">
                            <option value="">All Types</option>
                            @foreach(['Workshop', 'Seminar', 'Competition', 'Festival', 'Meetup'] as $type)
                                <option value="{{ $type }}" {{ request('event_type') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>

                    <button type="submit" class="px-6 py-3 rounded-xl bg-kuet-600 text-white text-sm font-semibold hover:bg-kuet-700 transition-all flex items-center gap-2 shadow-lg shadow-kuet-500/20">
                        <i class="fas fa-filter text-xs"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'club_id', 'event_type']))
                        <a href="{{ route('events.index', ['view' => request('view', 'grid')]) }}" class="px-4 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
                            <i class="fas fa-times text-xs"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>

            <!-- Active filters display -->
            @if(request()->hasAny(['search', 'club_id', 'event_type']))
                <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-slate-100">
                    <span class="text-xs text-slate-500 font-medium">Active filters:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-kuet-50 text-kuet-700 text-xs font-medium border border-kuet-100">
                            Search: {{ request('search') }}
                            <a href="{{ route('events.index', array_diff_key(request()->all(), ['search' => ''])) }}" class="hover:text-kuet-900"><i class="fas fa-times"></i></a>
                        </span>
                    @endif
                    @if(request('club_id'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium border border-blue-100">
                            Club: {{ $clubs->firstWhere('id', request('club_id'))?->name }}
                            <a href="{{ route('events.index', array_diff_key(request()->all(), ['club_id' => ''])) }}" class="hover:text-blue-900"><i class="fas fa-times"></i></a>
                        </span>
                    @endif
                    @if(request('event_type'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-medium border border-purple-100">
                            Type: {{ request('event_type') }}
                            <a href="{{ route('events.index', array_diff_key(request()->all(), ['event_type' => ''])) }}" class="hover:text-purple-900"><i class="fas fa-times"></i></a>
                        </span>
                    @endif
                </div>
            @endif
        </div>
        @endif

        <!-- Smart Calendar View with FullCalendar v6 -->
        @if(request('view') === 'calendar')
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-kuet-500"></i>
                            Event Calendar
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">Click on any event to view details</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Approved
                        </span>
                        @auth
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'organizer')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-medium border border-amber-100">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="p-6">
                    <div id="smart-calendar"></div>
                </div>
            </div>

            @push('scripts')
                <!-- FullCalendar v6 global bundle from CDN -->
                <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.21/index.global.min.js'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var calendarEl = document.getElementById('smart-calendar');
                        var calendarEvents = @json($calendarEvents ?? []);

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,listMonth'
                            },
                            buttonText: {
                                today: 'Today',
                                month: 'Month',
                                week: 'Week',
                                list: 'List'
                            },
                            events: calendarEvents,
                            eventClick: function(info) {
                                if (info.event.extendedProps.url) {
                                    window.location.href = info.event.extendedProps.url;
                                }
                            },
                            eventDidMount: function(info) {
                                info.el.title = info.event.title + '\n' +
                                    'Club: ' + (info.event.extendedProps.club || 'N/A') + '\n' +
                                    'Venue: ' + (info.event.extendedProps.venue || 'N/A') + '\n' +
                                    'Status: ' + (info.event.extendedProps.status || 'N/A');
                            },
                            height: 'auto',
                            dayMaxEvents: 3,
                            moreLinkClick: 'popover',
                            eventTimeFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            },
                            slotMinTime: '08:00:00',
                            slotMaxTime: '22:00:00',
                            nowIndicator: true,
                            navLinks: true,
                            selectable: false,
                            editable: false,
                            locale: 'en',
                            firstDay: 0,
                            fixedWeekCount: false,
                            showNonCurrentDates: false
                        });
                        calendar.render();
                    });
                </script>
            @endpush
        @endif

        <!-- My Events View (for logged-in students) -->
        @if(request('view') === 'my' && auth()->check() && auth()->user()->role === 'student')
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-user-check text-kuet-500"></i>
                        My Registered Events
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Events you have registered for</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @php
                        $myEvents = auth()->user()->registrations()->with('event.club')->latest()->get();
                    @endphp
                    @forelse($myEvents as $reg)
                        <div class="p-5 hover:bg-slate-50 transition-colors flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-kuet-100 flex items-center justify-center text-kuet-600 flex-shrink-0">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-slate-900 text-sm truncate">{{ $reg->event->title }}</h3>
                                    <p class="text-xs text-slate-500">{{ $reg->event->club->name }} &bull; {{ $reg->event->event_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $reg->registration_status === 'Approved' ? 'bg-emerald-50 text-emerald-700' :
                                       ($reg->registration_status === 'Pending' ? 'bg-amber-50 text-amber-700' :
                                       ($reg->registration_status === 'Waitlisted' ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-700')) }}">
                                    {{ $reg->registration_status }}
                                </span>
                                <a href="{{ route('events.show', $reg->event) }}" class="text-kuet-600 hover:text-kuet-700 text-sm font-medium">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-times text-2xl text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">No registered events</h3>
                            <p class="text-slate-500 text-sm mb-4">You haven't registered for any events yet.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-kuet-600 text-white text-sm font-semibold hover:bg-kuet-700 transition-all">
                                <i class="fas fa-search text-xs"></i>
                                Browse Events
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Grid View (default) -->
        @if(request('view', 'grid') === 'grid')
            <!-- Results Count -->
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-slate-500">
                    Showing <span class="font-semibold text-slate-900">{{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-900">{{ $events->total() }}</span> events
                </p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Sort by:</span>
                    <select class="text-sm border-0 bg-transparent font-medium text-slate-700 focus:ring-0 cursor-pointer" onchange="window.location.href=this.value">
                        <option value="{{ route('events.index', array_merge(request()->all(), ['sort' => 'latest'])) }}" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="{{ route('events.index', array_merge(request()->all(), ['sort' => 'date'])) }}" {{ request('sort') === 'date' ? 'selected' : '' }}>Event Date</option>
                        <option value="{{ route('events.index', array_merge(request()->all(), ['sort' => 'seats'])) }}" {{ request('sort') === 'seats' ? 'selected' : '' }}>Seats Available</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($events as $event)
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 card-lift flex flex-col">
                        <!-- Card Header with Type Badge -->
                        <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                            @if($event->banner)
                                <img src="{{ $event->banner }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-4xl text-slate-300"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-kuet-700 shadow-sm">
                                    {{ $event->event_type }}
                                </span>
                            </div>
                            <!-- Dynamic status badge based on user role -->
                            <div class="absolute top-4 right-4">
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <span class="px-3 py-1 rounded-full {{ $event->status === 'Approved' ? 'bg-emerald-500/90' : ($event->status === 'Pending' ? 'bg-amber-500/90' : 'bg-red-500/90') }} backdrop-blur-sm text-xs font-bold text-white shadow-sm">
                                            <i class="fas {{ $event->status === 'Approved' ? 'fa-check-circle' : ($event->status === 'Pending' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>{{ $event->status }}
                                        </span>
                                    @elseif(auth()->user()->role === 'organizer' && auth()->user()->organizerClub && auth()->user()->organizerClub->id === $event->club_id)
                                        <span class="px-3 py-1 rounded-full {{ $event->status === 'Approved' ? 'bg-emerald-500/90' : ($event->status === 'Pending' ? 'bg-amber-500/90' : 'bg-red-500/90') }} backdrop-blur-sm text-xs font-bold text-white shadow-sm">
                                            <i class="fas {{ $event->status === 'Approved' ? 'fa-check-circle' : ($event->status === 'Pending' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>{{ $event->status }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-emerald-500/90 backdrop-blur-sm text-xs font-bold text-white shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i>Approved
                                        </span>
                                    @endif
                                @else
                                    <span class="px-3 py-1 rounded-full bg-emerald-500/90 backdrop-blur-sm text-xs font-bold text-white shadow-sm">
                                        <i class="fas fa-check-circle mr-1"></i>Approved
                                    </span>
                                @endauth
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-kuet-100 flex items-center justify-center text-kuet-600">
                                    <i class="fas fa-building text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-slate-600">{{ $event->club->name }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-kuet-700 transition-colors line-clamp-2">
                                {{ $event->title }}
                            </h3>

                            <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2 flex-1">
                                {{ Str::limit($event->description, 120) }}
                            </p>

                            <!-- Event Meta -->
                            <div class="space-y-2 mb-5">
                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                    <i class="fas fa-map-marker-alt w-4 text-slate-400"></i>
                                    <span>{{ $event->venue }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                    <i class="fas fa-calendar w-4 text-slate-400"></i>
                                    <span>{{ $event->event_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-chair w-4 text-slate-400"></i>
                                    <span class="{{ $event->remaining_seats > 10 ? 'text-emerald-600' : ($event->remaining_seats > 0 ? 'text-amber-600' : 'text-red-600') }} font-medium">
                                        {{ $event->remaining_seats }} seats left
                                    </span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 pt-4 border-t border-slate-100">
                                <a href="{{ route('events.show', $event) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-all">
                                    Details
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                                @if($event->remaining_seats > 0 && $event->status === 'Approved')
                                    <a href="{{ route('registrations.create', $event) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border-2 border-kuet-600 text-kuet-700 text-sm font-semibold hover:bg-kuet-50 transition-all">
                                        Register
                                    </a>
                                @else
                                    <span class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-sm font-medium cursor-not-allowed">
                                        {{ $event->status !== 'Approved' ? 'Not Available' : 'Full' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mb-6">
                            <i class="fas fa-search text-3xl text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">No events found</h3>
                        <p class="text-slate-500 max-w-md">No events match your search criteria. Try adjusting your filters or check back later.</p>
                        <a href="{{ route('events.index') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-kuet-600 text-white text-sm font-semibold hover:bg-kuet-700 transition-all">
                            <i class="fas fa-redo text-xs"></i>
                            View All Events
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection