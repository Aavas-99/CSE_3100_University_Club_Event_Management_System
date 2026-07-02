<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl kuet-auth-card">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Welcome Back</h1>
            <p class="text-sm text-slate-500">Choose a role to sign in</p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('login.student') }}" class="btn btn-primary w-full">Student Sign In</a>
            <a href="{{ route('login.organizer') }}" class="btn btn-primary w-full">Club Organizer Sign In</a>
            <a href="{{ route('login.admin') }}" class="btn btn-primary w-full">Admin Sign In</a>
        </div>

        <div class="mt-6 text-center text-sm text-slate-600">
            <a href="{{ route('register') }}" class="text-green-700 font-medium">Create a new account</a>
        </div>
    </div>
</body>
</html>

