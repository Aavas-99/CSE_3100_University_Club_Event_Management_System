<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KUET Event Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kuet: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-slate-800 antialiased">

    @include('partials.navbar')

    <main class="pt-28">
        @unless(request()->routeIs('home') || request()->is('/'))
            <div class="max-w-7xl mx-auto px-6 mb-6">
                <button type="button" onclick="history.back()" class="inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </button>
            </div>
        @endunless

        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.login-modal')

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>