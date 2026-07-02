<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>
        @include('partials.flash')
        <form method="POST" action="{{ url('/profile') }}">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm">Student ID</label>
                    <input type="text" name="student_id" value="{{ old('student_id', $user->student_id) }}" class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm">Department</label>
                    <input type="text" name="department" value="{{ old('department', $user->department) }}" class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm">New Password (leave blank to keep)</label>
                    <input type="password" name="password" class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border px-3 py-2">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="rounded-lg bg-green-700 px-4 py-2 text-white">Update Profile</button>
            </div>
        </form>
    </div>
</body>
</html>
