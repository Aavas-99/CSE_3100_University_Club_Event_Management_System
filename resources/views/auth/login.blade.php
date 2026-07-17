<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | KUET EMS</title>
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
    <style>
        .glass { background: rgba(255,255,255,0.9); backdrop-filter: blur(12px); }
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(30deg) translateX(-100%); transition: transform 0.6s;
        }
        .btn-shine:hover::after { transform: rotate(30deg) translateX(100%); }
    </style>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-kuet-900/30 via-slate-950 to-slate-950"></div>
    <div class="absolute top-20 left-20 w-72 h-72 bg-kuet-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>

    <div class="relative w-full max-w-md">
        <!-- Back button to home page -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm mb-6 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Back to Home
        </a>
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-kuet-500/25 mb-4">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
            <p class="text-slate-400 text-sm mt-1">Choose your role to sign in</p>
        </div>

        <!-- Role Cards -->
        <div class="space-y-3 mb-6">
            <a href="{{ route('login.student') }}" class="group flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-blue-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-graduate text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-sm">Student Sign In</h3>
                    <p class="text-slate-400 text-xs">Browse and register for events</p>
                </div>
                <i class="fas fa-arrow-right text-slate-500 group-hover:text-white transition-colors"></i>
            </a>

            <a href="{{ route('login.organizer') }}" class="group flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-kuet-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-kuet-500/20 flex items-center justify-center text-kuet-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users-cog text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-sm">Club Organizer Sign In</h3>
                    <p class="text-slate-400 text-xs">Manage events and registrations</p>
                </div>
                <i class="fas fa-arrow-right text-slate-500 group-hover:text-white transition-colors"></i>
            </a>

            <a href="{{ route('login.admin') }}" class="group flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-purple-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shield-alt text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-white font-semibold text-sm">Admin Sign In</h3>
                    <p class="text-slate-400 text-xs">Platform administration</p>
                </div>
                <i class="fas fa-arrow-right text-slate-500 group-hover:text-white transition-colors"></i>
            </a>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-slate-400 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-kuet-400 font-semibold hover:text-kuet-300 transition-colors">Create one</a>
            </p>
        </div>
    </div>
</body>
</html>

