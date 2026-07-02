<div class="text-center mb-4">
    <h2 class="text-xl font-bold text-slate-800">Choose Login Role</h2>
    <p class="text-sm text-slate-500 mt-1">Select your role to continue</p>
</div>

<div class="space-y-3">
    <a href="{{ route('login.student') }}" class="btn btn-primary w-full">Student Login</a>
    <a href="{{ route('login.organizer') }}" class="btn btn-primary w-full">Club Organizer Login</a>
    <a href="{{ route('login.admin') }}" class="btn btn-primary w-full">Admin Login</a>
</div>

<div class="mt-6 text-center text-sm text-slate-600">
    <a href="{{ route('register') }}" class="text-green-700 font-medium">Create a new account</a>
</div>

