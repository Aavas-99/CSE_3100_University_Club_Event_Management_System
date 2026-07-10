@extends('layouts.app')

@section('title', 'Create Event | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-kuet-100 flex items-center justify-center text-kuet-600">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Request New Event</h1>
                    <p class="text-slate-500 text-sm mt-1">Submit event details for admin approval</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <!-- Club Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-50 text-kuet-700 text-sm font-medium border border-kuet-100 mb-6">
            <i class="fas fa-building text-xs"></i>
            Club: {{ $club->name }}
        </div>

        <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <!-- Basic Info -->
                <div class="p-8 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-kuet-100 text-kuet-600 flex items-center justify-center text-sm font-bold">1</span>
                        Basic Information
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Event Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                placeholder="e.g., Annual Tech Fest 2026">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Event Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="event_type" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus appearance-none cursor-pointer transition-all">
                                    <option value="Workshop" {{ old('event_type') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="Seminar" {{ old('event_type') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="Competition" {{ old('event_type') === 'Competition' ? 'selected' : '' }}>Competition</option>
                                    <option value="Festival" {{ old('event_type') === 'Festival' ? 'selected' : '' }}>Festival</option>
                                    <option value="Meetup" {{ old('event_type') === 'Meetup' ? 'selected' : '' }}>Meetup</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Seat Limit <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="seat_limit" min="1" value="{{ old('seat_limit', 100) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all resize-none"
                                placeholder="Describe the goals, agenda, and what attendees can expect...">{{ old('description') }}</textarea>
                            <p class="text-xs text-slate-400 mt-1">Markdown formatting supported</p>
                        </div>
                    </div>
                </div>
                
                <!-- Location & Time -->
                <div class="p-8 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">2</span>
                        Location & Schedule
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Venue <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="venue" value="{{ old('venue') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                placeholder="e.g., Main Auditorium, Academic Building">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Event Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Registration Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="registration_deadline" value="{{ old('registration_deadline') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                End Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                        </div>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="p-8 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-slate-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Your event will be reviewed by an admin before going live.
                    </p>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-white transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white text-sm font-semibold hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/20 btn-shine flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Submit for Approval
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection