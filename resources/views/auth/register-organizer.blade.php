<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register (Club Representative) | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl rounded-2xl bg-white p-8 shadow-xl">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Create Your KUET EMS Club Representative Account</h1>
            <p class="text-sm text-slate-500">Register to create and manage club events</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="organizer">

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    <p class="font-semibold">Please fix the following errors:</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Full Name</label>
                    <input type="text" name="name" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Student ID</label>
                    <input type="text" name="student_id" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('student_id') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Department</label>
                    <select name="department" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="CSE" {{ old('department', 'CSE') === 'CSE' ? 'selected' : '' }}>CSE</option>
                        <option value="EEE" {{ old('department') === 'EEE' ? 'selected' : '' }}>EEE</option>
                        <option value="CE" {{ old('department') === 'CE' ? 'selected' : '' }}>CE</option>
                        <option value="ME" {{ old('department') === 'ME' ? 'selected' : '' }}>ME</option>
                        <option value="ECE" {{ old('department') === 'ECE' ? 'selected' : '' }}>ECE</option>
                        <option value="IEM" {{ old('department') === 'IEM' ? 'selected' : '' }}>IEM</option>
                        <option value="ESE" {{ old('department') === 'ESE' ? 'selected' : '' }}>ESE</option>
                        <option value="BME" {{ old('department') === 'BME' ? 'selected' : '' }}>BME</option>
                        <option value="URP" {{ old('department') === 'URP' ? 'selected' : '' }}>URP</option>
                        <option value="LE" {{ old('department') === 'LE' ? 'selected' : '' }}>LE</option>
                        <option value="TE" {{ old('department') === 'TE' ? 'selected' : '' }}>TE</option>
                        <option value="BECM" {{ old('department') === 'BECM' ? 'selected' : '' }}>BECM</option>
                        <option value="ARCH" {{ old('department') === 'ARCH' ? 'selected' : '' }}>ARCH</option>
                        <option value="MSE" {{ old('department') === 'MSE' ? 'selected' : '' }}>MSE</option>
                        <option value="CHE" {{ old('department') === 'CHE' ? 'selected' : '' }}>CHE</option>
                        <option value="MTE" {{ old('department') === 'MTE' ? 'selected' : '' }}>MTE</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" name="phone" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('phone') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Club Name</label>
                    <input type="text" name="club_name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('club_name') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Club Description</label>
                    <textarea name="club_description" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('club_description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Club Logo (URL)</label>
                    <input type="text" name="club_logo" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('club_logo') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <button type="submit" class="w-full rounded-lg bg-green-700 px-4 py-2 font-semibold text-white">Register as Club Representative</button>
        </form>
        <div class="mt-6 text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="text-green-700 font-medium">Already have an account?</a>
        </div>
    </div>
</body>
</html>
