<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl rounded-2xl bg-white p-8 shadow-xl">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Create Your KUET EMS Account</h1>
            <p class="text-sm text-slate-500">Register as a student, organizer, or admin</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Full Name</label>
                    <input type="text" name="name" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Student ID</label>
                    <input type="text" name="student_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Department</label>
                    <select name="department" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="EEE">EEE</option>
                        <option value="CSE">CSE</option>
                        <option value="CE">CE</option>
                        <option value="ME">ME</option>
                        <option value="ECE">ECE</option>
                        <option value="IEM">IEM</option>
                        <option value="ESE">ESE</option>
                        <option value="BME">BME</option>
                        <option value="URP">URP</option>
                        <option value="LE">LE</option>
                        <option value="TE">TE</option>
                        <option value="BECM">BECM</option>
                        <option value="ARCH">ARCH</option>
                        <option value="MSE">MSE</option>
                        <option value="CHE">CHE</option>
                        <option value="MTE">MTE</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" name="phone" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Role</label>
                    <select name="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="student">Student</option>
                        <option value="organizer">Club Organizer</option>
                    </select>
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
            <button type="submit" class="w-full rounded-lg bg-green-700 px-4 py-2 font-semibold text-white">Register</button>
        </form>
        <div class="mt-6 text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="text-green-700 font-medium">Already have an account?</a>
        </div>
    </div>
</body>
</html>
