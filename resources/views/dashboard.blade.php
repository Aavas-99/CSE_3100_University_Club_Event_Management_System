<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Welcome, {{ $user->name }}</h1>
                <p class="text-slate-600">Role: <span class="font-semibold capitalize">{{ $user->role }}</span></p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-white">Logout</button>
            </form>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="rounded-2xl bg-white p-6 shadow">
                <h2 class="text-lg font-semibold">Events</h2>
                <p class="text-sm text-slate-500">Manage and discover campus events.</p>
                <a href="{{ route('events.index') }}" class="mt-4 inline-block text-green-700 font-medium">Browse Events</a>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow">
                <h2 class="text-lg font-semibold">Clubs</h2>
                <p class="text-sm text-slate-500">Explore university clubs and organizers.</p>
                <a href="{{ route('clubs.index') }}" class="mt-4 inline-block text-green-700 font-medium">View Clubs</a>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow">
                <h2 class="text-lg font-semibold">Profile</h2>
                <p class="text-sm text-slate-500">Keep your student information up to date.</p>
            </div>
        </div>
    </div>
</body>
</html>
