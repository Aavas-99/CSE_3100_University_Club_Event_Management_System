@extends('layouts.app')

@section('title', 'Events | KUET EMS')

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
        
        <!-- Search & Filter Panel -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
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
                        <a href="{{ route('events.index') }}" class="px-4 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
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
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/90 backdrop-blur-sm text-xs font-bold text-white shadow-sm">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                            </span>
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
                            @if($event->remaining_seats > 0)
                                <a href="{{ route('registrations.create', $event) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border-2 border-kuet-600 text-kuet-700 text-sm font-semibold hover:bg-kuet-50 transition-all">
                                    Register
                                </a>
                            @else
                                <span class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-sm font-medium cursor-not-allowed">
                                    Full
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
                    <p class="text-slate-500 max-w-md">No approved events match your search criteria. Try adjusting your filters or check back later.</p>
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
    </div>
</div>
@endsection