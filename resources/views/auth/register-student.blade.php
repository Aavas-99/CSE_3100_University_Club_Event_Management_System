<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register (Student) | KUET EMS</title>
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
<body class="min-h-screen bg-slate-950 py-12 px-4 relative">
    <!-- Background -->
    <div class="fixed inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950 pointer-events-none"></div>
    <div class="fixed top-20 right-20 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-2xl mx-auto">
        <!-- Back Link -->
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm mb-6 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Back to options
        </a>

        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-400 text-xl mb-4">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Student Registration</h1>
                <p class="text-slate-400 text-sm mt-1">Create your KUET EMS student account</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3">
                    <p class="text-sm font-semibold text-red-400 mb-2">Please fix the following errors:</p>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-400 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px]"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="student">

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Full Name <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Student ID <span class="text-red-400">*</span></label>
                        <input type="text" name="student_id" value="{{ old('student_id') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Department <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="department" required
                                class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                                @foreach(['EEE','CSE','CE','ME','ECE','IEM','ESE','BME','URP','LE','TE','BECM','ARCH','MSE','CHE','MTE'] as $dept)
                                    <option value="{{ $dept }}" {{ old('department', 'CSE') === $dept ? 'selected' : '' }} class="bg-slate-800">{{ $dept }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Phone <span class="text-red-400">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Confirm Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        <p class="text-xs text-slate-500 mt-1">Min 8 chars: uppercase, lowercase, number & symbol</p>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold text-sm hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 mt-6">
                    <i class="fas fa-user-plus"></i>
                    Create Student Account
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10 text-center">
                <p class="text-sm text-slate-400">
                    Already have an account? <a href="{{ route('login.student') }}" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
