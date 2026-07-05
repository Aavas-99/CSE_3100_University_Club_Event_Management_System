@extends('layouts.app')

@section('title', $event->title . ' | KUET EMS')

@section('content')
<div class="bg-slate-100 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200">
            @include('partials.flash')
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900">{{ $event->title }}</h1>
                    <p class="mt-3 text-slate-600">Hosted by <span class="font-semibold text-slate-900">{{ $event->club->name }}</span></p>
                </div>
                <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Back to Events</a>
            </div>

            <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
                <div>
                    <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200 mb-6">
                        <h2 class="text-xl font-semibold text-slate-900 mb-3">Event overview</h2>
                        <p class="text-slate-600 leading-relaxed">{{ $event->description }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white p-5 border border-slate-200">
                            <p class="text-sm text-slate-500">Date</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $event->event_date }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 border border-slate-200">
                            <p class="text-sm text-slate-500">Time</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $event->start_time }} - {{ $event->end_time }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 border border-slate-200">
                            <p class="text-sm text-slate-500">Venue</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $event->venue }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 border border-slate-200">
                            <p class="text-sm text-slate-500">Seats left</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $event->remaining_seats }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-slate-900">Event details</h2>
                        <p class="text-slate-500 mt-2">Approved by admin and ready for student registrations.</p>
                    </div>
                    <div class="space-y-4 text-sm text-slate-600">
                        <div class="rounded-3xl bg-white p-4 border border-slate-200">
                            <p class="text-slate-500">Club organizer</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ $event->club->organizer->name }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-4 border border-slate-200">
                            <p class="text-slate-500">Registration deadline</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ $event->registration_deadline }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-4 border border-slate-200">
                            <p class="text-slate-500">Event type</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ $event->event_type }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        @if(auth()->check() && auth()->user()->role === 'student')
                            <a href="{{ route('registrations.create', $event) }}" class="w-full inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white hover:bg-kuet-800">Request Registration</a>
                        @else
                            <a href="{{ route('login.student') }}" class="w-full inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white hover:bg-kuet-800">Sign in as Student to register</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
