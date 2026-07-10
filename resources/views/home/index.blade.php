@extends('layouts.app')

@section('title', 'KUET Event Management System')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center overflow-hidden bg-slate-950">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-kuet-900/40 via-slate-950 to-slate-950"></div>
        <div class="absolute top-0 left-0 w-full h-full opacity-30">
            <div class="absolute top-20 left-20 w-72 h-72 bg-kuet-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
        </div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div class="space-y-8 animate-slide-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-500/10 border border-kuet-500/20 text-kuet-400 text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-kuet-400 animate-pulse"></span>
                    KUET Official Platform
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold text-white leading-[1.1]">
                    Discover & Manage
                    <span class="gradient-text block mt-2">Campus Events</span>
                </h1>
                
                <p class="text-lg text-slate-400 max-w-lg leading-relaxed">
                    Your one-stop platform for discovering, registering, and managing university events. 
                    From tech workshops to cultural festivals — everything at your fingertips.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('events.index') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-kuet-600 to-kuet-700 text-white font-semibold rounded-2xl shadow-lg shadow-kuet-500/25 hover:shadow-kuet-500/40 hover:from-kuet-700 hover:to-kuet-800 transition-all btn-shine">
                        <i class="fas fa-rocket group-hover:translate-x-1 transition-transform"></i>
                        Explore Events
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white/5 text-white font-semibold rounded-2xl border border-white/10 hover:bg-white/10 transition-all backdrop-blur-sm">
                        <i class="fas fa-user-plus"></i>
                        Get Started
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="flex gap-8 pt-4">
                    <div>
                        <p class="text-3xl font-bold text-white">150+</p>
                        <p class="text-sm text-slate-500">Events Hosted</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">25+</p>
                        <p class="text-sm text-slate-500">Active Clubs</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">5K+</p>
                        <p class="text-sm text-slate-500">Students</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Interactive Card -->
            <div class="hidden lg:block relative">
                <div class="relative">
                    <!-- Glow effect -->
                    <div class="absolute -inset-4 bg-gradient-to-r from-kuet-500/20 to-blue-500/20 rounded-3xl blur-2xl"></div>
                    
                    <!-- Main card -->
                    <div class="relative bg-slate-900/80 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-8 space-y-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-semibold">Upcoming Events</h3>
                                <p class="text-slate-400 text-sm">This week at KUET</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-kuet-500/20 text-kuet-400 text-xs font-medium">Live</span>
                        </div>
                        
                        <!-- Event items -->
                        <div class="space-y-3">
                            @php
                                $sampleEvents = [
                                    ['title' => 'Tech Fest 2026', 'club' => 'CSE Club', 'date' => 'Mar 15', 'color' => 'kuet'],
                                    ['title' => 'Robotics Workshop', 'club' => 'EEE Club', 'date' => 'Mar 18', 'color' => 'blue'],
                                    ['title' => 'Cultural Night', 'club' => 'Arts Club', 'date' => 'Mar 20', 'color' => 'purple'],
                                ];
                            @endphp
                            
                            @foreach($sampleEvents as $event)
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-all cursor-pointer group">
                                    <div class="w-12 h-12 rounded-xl bg-{{ $event['color'] }}-500/20 flex items-center justify-center text-{{ $event['color'] }}-400 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-medium text-sm truncate">{{ $event['title'] }}</h4>
                                        <p class="text-slate-400 text-xs">{{ $event['club'] }}</p>
                                    </div>
                                    <span class="text-slate-500 text-xs font-medium">{{ $event['date'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- CTA -->
                        <a href="{{ route('events.index') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-kuet-600/20 text-kuet-400 text-sm font-medium hover:bg-kuet-600/30 transition-all">
                            View All Events
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-50 text-kuet-700 text-sm font-semibold border border-kuet-100">
                <i class="fas fa-info-circle text-xs"></i>
                About the Platform
            </span>
            <h2 class="mt-6 text-4xl font-bold text-slate-900">Built for the KUET Community</h2>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed">
                A centralized system designed to streamline event management across all university clubs and departments.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @php
                $aboutCards = [
                    ['icon' => 'fa-bullseye', 'title' => 'Our Mission', 'desc' => 'To simplify event discovery and participation for every KUET student through a unified digital platform.', 'gradient' => 'from-emerald-400 to-kuet-600', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-100'],
                    ['icon' => 'fa-eye', 'title' => 'Our Vision', 'desc' => 'Creating a vibrant campus culture where no student misses out on opportunities to learn, grow, and connect.', 'gradient' => 'from-blue-400 to-blue-600', 'bg' => 'bg-blue-50', 'border' => 'border-blue-100'],
                    ['icon' => 'fa-heart', 'title' => 'Our Values', 'desc' => 'Transparency, accessibility, and inclusivity in every event we help organize and promote.', 'gradient' => 'from-amber-400 to-orange-500', 'bg' => 'bg-amber-50', 'border' => 'border-amber-100'],
                ];
            @endphp
            
            @foreach($aboutCards as $card)
                <div class="group relative p-8 rounded-3xl {{ $card['bg'] }} border {{ $card['border'] }} hover:shadow-xl hover:shadow-{{ explode('-', $card['bg'])[1] }}-500/10 transition-all duration-300 card-lift">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $card['gradient'] }} flex items-center justify-center text-white text-xl mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $card['title'] }}</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $card['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-50 text-kuet-700 text-sm font-semibold border border-kuet-100">
                <i class="fas fa-star text-xs"></i>
                Key Features
            </span>
            <h2 class="mt-6 text-4xl font-bold text-slate-900">Everything You Need</h2>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed">
                Powerful tools designed for students, club admins, and system administrators.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $features = [
                    ['icon' => 'fa-compass', 'title' => 'Event Discovery', 'desc' => 'Browse all upcoming events with advanced filtering by category, date, and club.', 'color' => 'kuet'],
                    ['icon' => 'fa-ticket-alt', 'title' => 'Easy Registration', 'desc' => 'One-click event registration with digital tickets and QR code check-ins.', 'color' => 'blue'],
                    ['icon' => 'fa-calendar-check', 'title' => 'Smart Calendar', 'desc' => 'Personal event calendar with reminders and schedule management.', 'color' => 'purple'],
                    ['icon' => 'fa-clipboard-check', 'title' => 'Approval Workflow', 'desc' => 'Streamlined event approval process from submission to publication.', 'color' => 'emerald'],
                    ['icon' => 'fa-chart-line', 'title' => 'Analytics Dashboard', 'desc' => 'Comprehensive insights on event performance and participation trends.', 'color' => 'orange'],
                    ['icon' => 'fa-bell', 'title' => 'Real-time Notifications', 'desc' => 'Instant alerts for approvals, reminders, and event updates.', 'color' => 'red'],
                ];
            @endphp
            
            @foreach($features as $feature)
                <div class="group p-6 bg-white rounded-2xl border border-slate-200 hover:border-{{ $feature['color'] }}-200 hover:shadow-lg hover:shadow-{{ $feature['color'] }}-500/5 transition-all duration-300 card-lift">
                    <div class="w-12 h-12 rounded-xl bg-{{ $feature['color'] }}-50 text-{{ $feature['color'] }}-600 flex items-center justify-center text-lg mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $feature['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Roles Section -->
<section id="roles" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-50 text-kuet-700 text-sm font-semibold border border-kuet-100">
                <i class="fas fa-users text-xs"></i>
                Access Portals
            </span>
            <h2 class="mt-6 text-4xl font-bold text-slate-900">Choose Your Portal</h2>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed">
                Secure login portals tailored for students, club administrators, and system administrators.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @php
                $roles = [
                    ['name' => 'Student', 'icon' => 'fa-user-graduate', 'desc' => 'Explore campus events, register for activities, view schedules, and track your participation history.', 'color' => 'blue', 'route' => 'login.student'],
                    ['name' => 'Club Admin', 'icon' => 'fa-users-cog', 'desc' => 'Manage events, registrations, attendance records, announcements, and club activities efficiently.', 'color' => 'kuet', 'route' => 'login.organizer'],
                    ['name' => 'Admin', 'icon' => 'fa-shield-alt', 'desc' => 'Control approvals, users, venues, reports, analytics, and overall platform operations.', 'color' => 'purple', 'route' => 'login.admin'],
                ];
            @endphp
            
            @foreach($roles as $role)
                <div class="group relative p-8 rounded-3xl bg-gradient-to-b from-{{ $role['color'] }}-50/50 to-white border border-{{ $role['color'] }}-100 hover:border-{{ $role['color'] }}-200 hover:shadow-xl hover:shadow-{{ $role['color'] }}-500/10 transition-all duration-300 card-lift">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-{{ $role['color'] }}-400 to-{{ $role['color'] }}-600 rounded-t-3xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $role['color'] }}-400 to-{{ $role['color'] }}-600 flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-{{ $role['color'] }}-500/25 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $role['icon'] }}"></i>
                    </div>
                    
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-{{ $role['color'] }}-100 text-{{ $role['color'] }}-700 text-xs font-bold uppercase tracking-wider mb-4">
                        {{ $role['name'] }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $role['name'] }} Portal</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $role['desc'] }}</p>
                    
                    <a href="{{ route($role['route']) }}" class="inline-flex items-center justify-center w-full gap-2 px-6 py-3 rounded-xl bg-{{ $role['color'] }}-600 text-white font-semibold hover:bg-{{ $role['color'] }}-700 transition-all btn-shine">
                        Sign In
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-kuet-800 via-kuet-900 to-slate-950"></div>
    <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.4%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Get Started?</h2>
        <p class="text-lg text-white/70 mb-10 max-w-2xl mx-auto leading-relaxed">
            Join thousands of KUET students and clubs already using the platform to discover and manage amazing events.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-kuet-800 font-semibold rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                <i class="fas fa-rocket"></i>
                Create Account
            </a>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white/10 text-white font-semibold rounded-2xl border border-white/20 hover:bg-white/20 transition-all">
                <i class="fas fa-search"></i>
                Browse Events
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kuet-50 text-kuet-700 text-sm font-semibold border border-kuet-100">
                <i class="fas fa-envelope text-xs"></i>
                Get in Touch
            </span>
            <h2 class="mt-6 text-4xl font-bold text-slate-900">Contact Us</h2>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed">
                Have questions or need assistance? We're here to help.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @php
                $contacts = [
                    ['icon' => 'fa-envelope', 'title' => 'Email', 'info' => 'support@kuet.ac.bd', 'color' => 'kuet'],
                    ['icon' => 'fa-phone', 'title' => 'Phone', 'info' => '+880 41-769468', 'color' => 'blue'],
                    ['icon' => 'fa-map-marker-alt', 'title' => 'Location', 'info' => 'KUET, Khulna-9203', 'color' => 'purple'],
                ];
            @endphp
            
            @foreach($contacts as $contact)
                <div class="group p-6 bg-white rounded-2xl border border-slate-200 text-center hover:border-{{ $contact['color'] }}-200 hover:shadow-lg transition-all duration-300 card-lift">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-{{ $contact['color'] }}-50 text-{{ $contact['color'] }}-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $contact['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $contact['title'] }}</h3>
                    <p class="text-slate-500 text-sm">{{ $contact['info'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection