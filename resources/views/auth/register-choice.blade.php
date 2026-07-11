<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | KUET EMS</title>
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
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-kuet-900/20 via-slate-950 to-slate-950"></div>
    <div class="absolute top-20 left-20 w-72 h-72 bg-kuet-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>

    <div class="relative w-full max-w-lg">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-kuet-500/25 mb-4">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Create Account</h1>
            <p class="text-slate-400 text-sm mt-1">Choose your registration type</p>
        </div>

        <!-- Options -->
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('register.student') }}" class="group p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-blue-500/10 hover:border-blue-500/30 transition-all text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-400 text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="text-white font-semibold mb-2">Student</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Register as a student to browse and join campus events</p>
            </a>

            <a href="{{ route('register.organizer') }}" class="group p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-kuet-500/10 hover:border-kuet-500/30 transition-all text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-kuet-500/20 flex items-center justify-center text-kuet-400 text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3 class="text-white font-semibold mb-2">Club Representative</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Register to create and manage events for your club</p>
            </a>
        </div>

        <!-- Login Link -->
        <div class="mt-8 text-center">
            <p class="text-slate-400 text-sm">
                Already have an account? <a href="{{ route('login') }}" class="text-kuet-400 font-semibold hover:text-kuet-300 transition-colors">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>
