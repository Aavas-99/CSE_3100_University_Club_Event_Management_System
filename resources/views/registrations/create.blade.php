@extends('layouts.app')

@section('title', 'Register for Event | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-100 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <div class="rounded-3xl bg-white shadow-xl p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Register for "{{ $event->title }}"</h1>
                <p class="text-slate-500">Complete your registration request and share the required details with the organizer.</p>
            </div>

            @include('partials.flash')

            <div class="grid gap-6 md:grid-cols-2 mb-6">
                <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Event Summary</h2>
                    <p class="text-slate-600">{{ $event->description }}</p>
                    <div class="mt-4 space-y-2 text-sm text-slate-600">
                        <div><strong>Date:</strong> {{ $event->event_date }}</div>
                        <div><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</div>
                        <div><strong>Venue:</strong> {{ $event->venue }}</div>
                        <div><strong>Club:</strong> {{ $event->club->name }}</div>
                        <div><strong>Seats left:</strong> {{ $event->remaining_seats }}</div>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Your Details</h2>
                    <div class="space-y-2 text-sm text-slate-600">
                        <div><strong>Name:</strong> {{ $user->name }}</div>
                        <div><strong>Email:</strong> {{ $user->email }}</div>
                        <div><strong>Student ID:</strong> {{ $user->student_id }}</div>
                        <div><strong>Department:</strong> {{ $user->department ?? 'Not provided' }}</div>
                        <div><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('registrations.store', $event) }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Department</label>
                        <input type="text" name="department" value="{{ old('department', $user->department) }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Submission Note</h2>
                    <p class="text-slate-600">Once submitted, your request will be reviewed by the event organizer. Approved registrations receive a ticket automatically.</p>
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white shadow-lg shadow-kuet-500/20 hover:bg-kuet-800">Submit Registration Request</button>
            </form>
        </div>
    </div>
</div>
@endsection
