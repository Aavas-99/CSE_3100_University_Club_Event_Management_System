@extends('layouts.app')

@section('title', 'Pending Event Approvals | KUET EMS')

@section('content')
<div class="bg-slate-100 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
        @include('partials.flash')
        <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Pending Event Approvals</h1>
                    <p class="text-slate-500">Review event submissions and approve or reject them.</p>
                </div>
                <span class="rounded-full bg-amber-100 px-4 py-2 text-amber-700 text-sm">{{ $events->count() }} pending</span>
            </div>

            <div class="grid gap-6">
                @forelse($events as $event)
                    <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200 shadow-sm">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">{{ $event->title }}</h2>
                                <p class="mt-2 text-slate-600">{{ Str::limit($event->description, 140) }}</p>
                                <p class="mt-3 text-sm text-slate-500">Club: {{ $event->club->name }} · Organizer: {{ $event->club->organizer->name }}</p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-green-700 px-5 py-3 text-white hover:bg-green-800">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-red-600 px-5 py-3 text-white hover:bg-red-700">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl bg-white p-10 border border-slate-200 text-center text-slate-500">
                        There are no pending event approval requests.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $events->links() }}</div>
        </div>
    </div>
</div>
@endsection
