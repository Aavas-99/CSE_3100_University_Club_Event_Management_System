<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-lg rounded-2xl bg-white p-8 shadow-xl text-center">
        <h1 class="text-2xl font-bold mb-4">Create an Account</h1>
        <p class="text-sm text-slate-500 mb-6">Choose your registration type</p>

        <div class="grid md:grid-cols-2 gap-6">
            <a href="{{ url('/register/student') }}" class="block rounded-lg border border-slate-200 p-6 hover:shadow-md">
                <h3 class="font-semibold text-lg">Student</h3>
                <p class="text-sm text-slate-500 mt-2">Register as a regular student to browse and join events.</p>
            </a>

            <a href="{{ url('/register/organizer') }}" class="block rounded-lg border border-slate-200 p-6 hover:shadow-md">
                <h3 class="font-semibold text-lg">Club Representative</h3>
                <p class="text-sm text-slate-500 mt-2">Register as a club representative to create and manage events for your club.</p>
            </a>
        </div>

        <div class="mt-6 text-sm">
            <a href="{{ route('login') }}" class="text-green-700">Already have an account? Sign in</a>
        </div>
    </div>
</body>
</html>
