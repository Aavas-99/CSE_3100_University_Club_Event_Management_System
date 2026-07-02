<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="rounded-2xl bg-white p-8 shadow">
        <h1 class="text-3xl font-bold text-slate-800">{{ $event->title }}</h1>
        <p class="mt-3 text-slate-600">{{ $event->description }}</p>
        <div class="mt-6 grid md:grid-cols-2 gap-6 text-sm text-slate-600">
            <div><strong>Club:</strong> {{ $event->club->name }}</div>
            <div><strong>Organizer:</strong> {{ $event->club->organizer->name }}</div>
            <div><strong>Venue:</strong> {{ $event->venue }}</div>
            <div><strong>Date:</strong> {{ $event->event_date }}</div>
            <div><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</div>
            <div><strong>Seats Left:</strong> {{ $event->remaining_seats }}</div>
            <div><strong>Deadline:</strong> {{ $event->registration_deadline }}</div>
            <div><strong>Type:</strong> {{ $event->event_type }}</div>
        </div>
        <form method="POST" action="{{ route('registrations.store', $event) }}" class="mt-8">
            @csrf
            <button class="rounded-lg bg-green-700 px-4 py-2 text-white">Register for this Event</button>
        </form>
    </div>
</div>
</body>
</html>
