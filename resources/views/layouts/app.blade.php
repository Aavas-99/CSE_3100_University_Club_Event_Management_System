<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KUET Event Management System')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
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
                        },
                        slate: {
                            850: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        
        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Card hover lift */
        .card-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }
        
        /* Button shine effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(30deg) translateX(-100%);
            transition: transform 0.6s;
        }
        .btn-shine:hover::after {
            transform: rotate(30deg) translateX(100%);
        }
        
        /* Status badges */
        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold;
        }
        
        /* Form focus ring */
        .input-focus:focus {
            @apply outline-none ring-2 ring-kuet-500 ring-offset-2 ring-offset-white border-kuet-500;
        }
        
        /* Page transition */
        .page-content {
            animation: slideUp 0.4s ease-out;
        }
        
        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">
    
    @include('partials.navbar')
    
    <main class="flex-1 pt-20">
        @unless(request()->routeIs('home') || request()->is('/'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
                <button type="button" onclick="history.back()" 
                    class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-kuet-700 transition-colors">
                    <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                    Back
                </button>
            </div>
        @endunless
        
        <div class="page-content">
            @yield('content')
        </div>
    </main>
    
    @include('partials.footer')
    
    <!-- Toast notifications container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>
    
    <script>
        // Toast notification system
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const colors = {
                success: 'bg-emerald-500',
                error: 'bg-red-500',
                warning: 'bg-amber-500',
                info: 'bg-blue-500'
            };
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            toast.className = `${colors[type]} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <i class="fas ${icons[type]}"></i>
                <span class="font-medium text-sm">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-2 opacity-75 hover:opacity-100">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            
            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-x-full'), 10);
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        };
        
        // Auto-show session messages as toasts
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}', 'success'));
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', () => showToast('{{ session('error') }}', 'error'));
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>