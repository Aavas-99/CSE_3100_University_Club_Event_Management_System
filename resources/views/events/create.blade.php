@extends('layouts.app')

@section('title', 'Create Event | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-100 py-12">
    <div class="max-w-5xl mx-auto px-6">
        <div class="rounded-3xl bg-white shadow-lg p-8">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Request New Event</h1>
                    <p class="text-slate-500">Submit the event details for your club. Admin approval is required before it goes live.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-4 py-2 text-slate-700 text-sm">Club: {{ $club->name }}</span>
            </div>

            @include('partials.flash')

            <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Event Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500" placeholder="Annual Tech Fest">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Event Type</label>
                        <select name="event_type" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                            <option value="Workshop" {{ old('event_type') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="Seminar" {{ old('event_type') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Competition" {{ old('event_type') === 'Competition' ? 'selected' : '' }}>Competition</option>
                            <option value="Festival" {{ old('event_type') === 'Festival' ? 'selected' : '' }}>Festival</option>
                            <option value="Meetup" {{ old('event_type') === 'Meetup' ? 'selected' : '' }}>Meetup</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Brief Description</label>
                    <textarea name="description" rows="5" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500" placeholder="Describe the goals and agenda of the event">{{ old('description') }}</textarea>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Venue</label>
                        <input type="text" name="venue" value="{{ old('venue') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500" placeholder="Main Auditorium">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Seat Limit</label>
                        <input type="number" name="seat_limit" min="1" value="{{ old('seat_limit', 100) }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Registration Deadline</label>
                        <input type="date" name="registration_deadline" value="{{ old('registration_deadline') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white shadow-lg shadow-kuet-500/20 hover:bg-kuet-800">Submit for Approval</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
