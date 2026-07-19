@extends('layouts.app')

@section('title', $event->title . ' | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Event Header Banner -->
    <div class="relative bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-kuet-900/50 via-slate-900 to-slate-950"></div>
        <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.4%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-full bg-kuet-500/20 text-kuet-400 text-xs font-bold border border-kuet-500/30">
                            {{ $event->event_type }}
                        </span>
                        <!-- Dynamic status badge - shows real status for admin/organizer, "Approved" for guests/students -->
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <span class="px-3 py-1 rounded-full {{ $event->status === 'Approved' ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : ($event->status === 'Pending' ? 'bg-amber-500/20 text-amber-400 border-amber-500/30' : 'bg-red-500/20 text-red-400 border-red-500/30') }} text-xs font-bold border">
                                    <i class="fas {{ $event->status === 'Approved' ? 'fa-check-circle' : ($event->status === 'Pending' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>{{ $event->status }}
                                </span>
                            @elseif(auth()->user()->role === 'organizer' && auth()->user()->organizerClub && auth()->user()->organizerClub->id === $event->club_id)
                                <span class="px-3 py-1 rounded-full {{ $event->status === 'Approved' ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : ($event->status === 'Pending' ? 'bg-amber-500/20 text-amber-400 border-amber-500/30' : 'bg-red-500/20 text-red-400 border-red-500/30') }} text-xs font-bold border">
                                    <i class="fas {{ $event->status === 'Approved' ? 'fa-check-circle' : ($event->status === 'Pending' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>{{ $event->status }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                                    <i class="fas fa-check-circle mr-1"></i>Approved
                                </span>
                            @endif
                        @else
                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                            </span>
                        @endauth
                    </div>
                    <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">{{ $event->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-slate-400 text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-building text-kuet-500"></i>
                            {{ $event->club->name }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-user-tie text-kuet-500"></i>
                            {{ $event->club->organizer->name }}
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 text-white text-sm font-medium hover:bg-white/20 transition-all backdrop-blur-sm border border-white/10 self-start">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Back to Events
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <div class="grid lg:grid-cols-[1fr_380px] gap-8">
            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Description Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-align-left text-kuet-500"></i>
                        About This Event
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {{ $event->description ?? 'No description available for this event.' }}
                    </div>
                </div>
                
                <!-- Details Grid -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-kuet-50 flex items-center justify-center text-kuet-600 flex-shrink-0">
                            <i class="fas fa-calendar-day text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Date</p>
                            <p class="text-lg font-bold text-slate-900">{{ $event->event_date->format('l, F d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Time</p>
                            <p class="text-lg font-bold text-slate-900">{{ $event->start_time }} - {{ $event->end_time }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Venue</p>
                            <p class="text-lg font-bold text-slate-900">{{ $event->venue }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0">
                            <i class="fas fa-hourglass-half text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Registration Deadline</p>
                            <p class="text-lg font-bold text-slate-900">{{ $event->registration_deadline->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Registration Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-900">Registration</h3>
                        <span class="px-3 py-1 rounded-full {{ $event->remaining_seats > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} text-xs font-bold">
                            {{ $event->remaining_seats > 0 ? $event->remaining_seats . ' seats left' : 'Sold Out' }}
                        </span>
                    </div>
                    
                    <!-- Seat Progress -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-500">Capacity</span>
                            <span class="font-semibold text-slate-900">{{ $event->seat_limit - $event->remaining_seats }} / {{ $event->seat_limit }}</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-kuet-500 to-kuet-400 rounded-full transition-all" 
                                 style="width: {{ (($event->seat_limit - $event->remaining_seats) / $event->seat_limit) * 100 }}%"></div>
                        </div>
                    </div>
                    
                    @if(auth()->check() && auth()->user()->role === 'student')
                        @php
                            $existingRegistration = \App\Models\Registration::where('user_id', auth()->id())->where('event_id', $event->id)->first();
                        @endphp
                        
                        @php
                            $isEnded = $event->event_date->toDateString() < now()->toDateString() || ($event->event_date->toDateString() == now()->toDateString() && \Carbon\Carbon::parse($event->end_time)->toTimeString() < now()->toTimeString());
                        @endphp

                        @if($existingRegistration)
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3">
                                    <i class="fas fa-info-circle text-xl"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-900">Already Registered</p>
                                <p class="text-xs text-slate-500 mt-1 mb-2">Status: <span class="font-medium {{ $existingRegistration->registration_status === 'Approved' ? 'text-emerald-600' : ($existingRegistration->registration_status === 'Pending' ? 'text-amber-600' : 'text-red-600') }}">{{ $existingRegistration->registration_status }}</span></p>
                                
                                @if($existingRegistration->registration_status === 'Approved' && $existingRegistration->ticket)
                                    <a href="{{ route('tickets.show', $existingRegistration->ticket) }}" class="mt-2 mb-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition-all shadow-md">
                                        <i class="fas fa-ticket-alt"></i> View Ticket
                                    </a>
                                @endif

                                <!-- Cancel button for any state -->
                                <form method="POST" action="{{ route('registrations.cancel', $existingRegistration) }}" class="mt-2" onsubmit="return confirm('Are you sure you want to cancel this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center justify-center gap-1 mx-auto transition-colors">
                                        <i class="fas fa-times-circle"></i> Cancel Registration
                                    </button>
                                </form>
                            </div>
                        @elseif($isEnded)
                            <div class="p-4 rounded-xl bg-slate-100 border border-slate-200 text-center">
                                <i class="fas fa-calendar-times text-slate-500 text-xl mb-2"></i>
                                <p class="text-sm font-semibold text-slate-700">Event Ended</p>
                            </div>
                        @elseif($event->remaining_seats > 0 && $event->status === 'Approved' && $event->registration_deadline >= now()->toDateString())
                            <a href="{{ route('registrations.create', $event) }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white font-semibold hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/25 btn-shine">
                                <i class="fas fa-ticket-alt"></i>
                                Register Now
                            </a>
                        @elseif($event->registration_deadline < now()->toDateString())
                            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-center">
                                <i class="fas fa-clock text-red-400 text-xl mb-2"></i>
                                <p class="text-sm font-semibold text-red-700">Registration Closed</p>
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                <i class="fas fa-ban text-slate-400 text-xl mb-2"></i>
                                <p class="text-sm font-semibold text-slate-600">Event Full</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login.student') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-all">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign in as Student to Register
                        </a>
                    @endif
                    
                    <!-- Organizer Info -->
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-3">Organized by</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($event->club->organizer->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $event->club->organizer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $event->club->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection