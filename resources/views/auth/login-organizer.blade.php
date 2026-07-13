<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Organizer Login | KUET EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        kuet: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac',
                            400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d',
                            800: '#166534', 900: '#14532d', 950: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4 relative">
    <!-- Background -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-kuet-900/30 via-slate-950 to-slate-950"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-kuet-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl"></div>

    <div class="relative w-full max-w-md">
        <!-- Back Link -->
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm mb-6 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> All login options
        </a>

        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-kuet-500/20 flex items-center justify-center text-kuet-400 text-xl mb-4">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Club Organizer Sign In</h1>
                <p class="text-slate-400 text-sm mt-1">Manage your club events</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-400 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px]"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.organizer') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all"
                            placeholder="organizer@kuet.ac.bd">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all"
                            placeholder="Enter your password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-600 bg-white/5 text-kuet-500 focus:ring-kuet-500">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white font-semibold text-sm hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/25 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10 text-center">
                <p class="text-sm text-slate-400">
                    New organizer? <a href="{{ route('register') }}" class="text-kuet-400 font-semibold hover:text-kuet-300 transition-colors">Create account</a>
                </p>
            </div>
        </div>

        <!-- Other Logins -->
        <div class="mt-6 flex justify-center gap-4 text-sm">
            <a href="{{ route('login.student') }}" class="text-slate-500 hover:text-blue-400 transition-colors">Student</a>
            <span class="text-slate-700">|</span>
            <a href="{{ route('login.admin') }}" class="text-slate-500 hover:text-purple-400 transition-colors">Admin</a>
        </div>
    </div>
</body>
</html>