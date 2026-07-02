<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Organizer Login | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl kuet-auth-card">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Club Organizer Sign In</h1>
            <p class="text-sm text-slate-500">Manage club events and registrations</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.organizer') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>

            <button type="submit" class="w-full rounded-lg bg-green-700 px-4 py-2 font-semibold text-white">Sign In</button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            <a href="{{ route('register') }}" class="text-green-700 font-medium">Create an organizer account</a>
        </div>

        <div class="mt-3 text-center text-sm">
            <a href="{{ route('login.student') }}" class="text-slate-600 hover:text-slate-900 font-medium">Login as Student</a>
        </div>
        <div class="mt-3 text-center text-sm">
            <a href="{{ route('login.admin') }}" class="text-slate-600 hover:text-slate-900 font-medium">Login as Admin</a>
        </div>
    </div>
</body>
</html>