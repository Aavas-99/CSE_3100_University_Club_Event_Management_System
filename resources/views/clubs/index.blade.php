@extends('layouts.app')

@section('title', 'Clubs | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">University Clubs</h1>
                    <p class="mt-2 text-slate-500">Discover KUET clubs and their upcoming activities.</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="fas fa-building"></i>
                    <span>{{ $clubs->total() }} clubs</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')

        <!-- Clubs Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($clubs as $club)
                <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 card-lift flex flex-col">
                    <!-- Card Header with Gradient -->
                    <div class="relative h-40 bg-gradient-to-br from-kuet-600 to-kuet-800 overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.4%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl font-bold border border-white/20">
                                    {{ strtoupper(substr($club->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-white font-bold text-lg truncate">{{ $club->name }}</h2>
                                    <span class="text-kuet-100 text-xs">{{ $club->events_count }} events</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-slate-600 text-sm leading-relaxed mb-4 line-clamp-3 flex-1">
                            {{ $club->description ?? 'No description available.' }}
                        </p>

                        <!-- Organizer Info -->
                        <div class="flex items-center gap-3 mb-5 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($club->organizer->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $club->organizer->name }}</p>
                                <p class="text-xs text-slate-500">Club Representative</p>
                            </div>
                        </div>

                        <!-- Stats Row -->
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="p-3 rounded-xl bg-kuet-50 text-center border border-kuet-100">
                                <p class="text-lg font-bold text-kuet-700">{{ $club->events_count }}</p>
                                <p class="text-xs text-kuet-600">Total Events</p>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-center border border-blue-100">
                                <p class="text-lg font-bold text-blue-700">
                                    {{ $club->events->where('status', 'Approved')->where('event_date', '>=', now()->toDateString())->count() }}
                                </p>
                                <p class="text-xs text-blue-600">Upcoming</p>
                            </div>
                        </div>

                        <!-- View Events Button - filters events by this club -->
                        <a href="{{ route('events.index', ['club_id' => $club->id]) }}"
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white text-sm font-semibold hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/20 btn-shine">
                            <i class="fas fa-calendar-alt"></i>
                            View Events
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mb-6">
                        <i class="fas fa-building text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No clubs yet</h3>
                    <p class="text-slate-500 max-w-md">Clubs will appear here once they are registered.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($clubs->hasPages())
            <div class="mt-10">
                {{ $clubs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection