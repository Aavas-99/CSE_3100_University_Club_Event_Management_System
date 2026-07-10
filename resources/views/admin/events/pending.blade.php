@extends('layouts.app')

@section('title', 'Pending Approvals | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Pending Event Approvals</h1>
                        <p class="text-slate-500 text-sm mt-1">Review and approve club event submissions</p>
                    </div>
                </div>
                <span class="px-4 py-2 rounded-full bg-amber-50 text-amber-700 text-sm font-bold border border-amber-100">
                    {{ $events->total() }} pending
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <div class="space-y-6">
            @forelse($events as $event)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            <!-- Event Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-xs font-bold">Pending Review</span>
                                    <span class="px-2 py-0.5 rounded-md bg-kuet-50 text-kuet-700 text-xs font-bold">{{ $event->event_type }}</span>
                                </div>
                                
                                <h2 class="text-xl font-bold text-slate-900 mb-2">{{ $event->title }}</h2>
                                <p class="text-slate-600 text-sm leading-relaxed mb-4">{{ Str::limit($event->description, 200) }}</p>
                                
                                <!-- Organizer Info -->
                                <div class="flex items-center gap-6 text-sm text-slate-500 mb-4">
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-building text-kuet-500"></i>
                                        {{ $event->club->name }}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-user-tie text-blue-500"></i>
                                        {{ $event->club->organizer->name }}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-calendar text-purple-500"></i>
                                        {{ $event->event_date->format('M d, Y') }}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                        {{ $event->venue }}
                                    </span>
                                </div>
                                
                                <!-- Event Details Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4">
                                    <div class="p-3 rounded-xl bg-slate-50 text-center">
                                        <p class="text-xs text-slate-500 mb-1">Date</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $event->event_date->format('M d') }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 text-center">
                                        <p class="text-xs text-slate-500 mb-1">Time</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $event->start_time }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 text-center">
                                        <p class="text-xs text-slate-500 mb-1">Seats</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $event->seat_limit }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 text-center">
                                        <p class="text-xs text-slate-500 mb-1">Deadline</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $event->registration_deadline->format('M d') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex lg:flex-col gap-3 lg:min-w-[140px]">
                                <form method="POST" action="{{ route('admin.events.approve', $event) }}" class="flex-1 lg:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20">
                                        <i class="fas fa-check"></i>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.events.reject', $event) }}" class="flex-1 lg:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full px-6 py-3 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100 transition-all flex items-center justify-center gap-2 border border-red-200">
                                        <i class="fas fa-times"></i>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-emerald-50 flex items-center justify-center mb-6">
                        <i class="fas fa-check-double text-3xl text-emerald-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">All caught up!</h3>
                    <p class="text-slate-500 max-w-md mx-auto">There are no pending event approval requests at the moment. New submissions will appear here.</p>
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