<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Upcoming Events</h1>
            <p class="text-slate-500">Browse and register for KUET club activities.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-white">Dashboard</a>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @foreach($events as $event)
            <div class="rounded-2xl bg-white p-6 shadow">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-semibold">{{ $event->title }}</h2>
                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">{{ $event->status }}</span>
                </div>
                <p class="text-slate-600 mb-2">{{ $event->description }}</p>
                <p class="text-sm text-slate-500">Club: {{ $event->club->name }}</p>
                <p class="text-sm text-slate-500">Venue: {{ $event->venue }} | Date: {{ $event->event_date }}</p>
                <p class="text-sm text-slate-500">Seats left: {{ $event->remaining_seats }}</p>
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('events.show', $event) }}" class="text-green-700 font-medium">View Details</a>
                    <form method="POST" action="{{ route('registrations.store', $event) }}">
                        @csrf
                        <button class="rounded-lg bg-green-700 px-3 py-2 text-sm text-white">Register</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $events->links() }}</div>
</div>
</body>
</html>
