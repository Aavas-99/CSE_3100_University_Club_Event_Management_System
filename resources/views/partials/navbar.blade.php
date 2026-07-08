<nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-slate-200/60 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-kuet-500/20 rounded-xl blur-lg group-hover:bg-kuet-500/30 transition-all"></div>
                    <img src="{{ asset('images/kuet-logo.png') }}" alt="KUET" class="relative h-10 w-auto rounded-lg">
                </div>
                <div class="hidden sm:flex flex-col">
                    <span class="text-lg font-bold text-slate-900 tracking-tight leading-tight">KUET EMS</span>
                    <span class="text-[10px] text-slate-500 font-medium tracking-wider uppercase">Event Management</span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-1">
                @guest
                    <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('home') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('events.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('events.index') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                        Events
                    </a>
                    <a href="{{ route('clubs.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('clubs.index') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                        Clubs
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('dashboard') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                        <i class="fas fa-th-large mr-1.5 text-xs"></i>Dashboard
                    </a>
                    <a href="{{ route('events.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('events.index') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                        <i class="fas fa-calendar-alt mr-1.5 text-xs"></i>Events
                    </a>
                    @if(auth()->user()->role === 'organizer')
                        <a href="{{ route('events.create') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('events.create') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                            <i class="fas fa-plus mr-1.5 text-xs"></i>Create Event
                        </a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.events.pending') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all {{ request()->routeIs('admin.events.pending') ? 'text-kuet-700 bg-kuet-50' : '' }}">
                            <i class="fas fa-check-double mr-1.5 text-xs"></i>Approvals
                        </a>
                    @endif
                @endguest
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-2">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-100 transition-all">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-kuet-50 hover:text-kuet-700 transition-colors">
                                <i class="fas fa-user-cog w-4"></i>Profile Settings
                            </a>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-kuet-50 hover:text-kuet-700 transition-colors">
                                <i class="fas fa-th-large w-4"></i>Dashboard
                            </a>
                            <div class="border-t border-slate-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-4"></i>Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-kuet-700 hover:bg-kuet-50 transition-all">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white text-sm font-semibold shadow-lg shadow-kuet-500/25 hover:shadow-kuet-500/40 hover:from-kuet-700 hover:to-kuet-800 transition-all btn-shine">
                        <i class="fas fa-rocket text-xs"></i>
                        Get Started
                    </a>
                @endauth
                
                <!-- Mobile menu button -->
                <button class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-lg">
        <div class="px-4 py-3 space-y-1">
            @guest
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Home</a>
                <a href="{{ route('events.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Events</a>
                <a href="{{ route('clubs.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Clubs</a>
            @else
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Dashboard</a>
                <a href="{{ route('events.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Events</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-kuet-50 hover:text-kuet-700">Profile</a>
            @endguest
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>