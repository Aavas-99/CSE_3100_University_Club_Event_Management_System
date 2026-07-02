<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">University Clubs</h1>
            <p class="text-slate-500">Discover KUET clubs and their upcoming activities.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-white">Dashboard</a>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @foreach($clubs as $club)
            <div class="rounded-2xl bg-white p-6 shadow">
                <h2 class="text-xl font-semibold">{{ $club->name }}</h2>
                <p class="text-slate-600 mt-2">{{ $club->description }}</p>
                <p class="text-sm text-slate-500 mt-3">Organizer: {{ $club->organizer->name }}</p>
                <p class="text-sm text-slate-500">Events: {{ $club->events_count }}</p>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
