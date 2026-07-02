@extends('layouts.app')

@section('title', 'KUET Event Management System')

@section('content')

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <!-- Animated Background Particles -->
        <div class="particles" id="particles"></div>
        
        <!-- Floating Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16 min-h-[calc(100vh-5rem)] py-20">
                <!-- Left Content -->
                <div class="hero-content lg:w-1/2">
                    <h1 class="hero-title">

                        <span class="block">Discover & Manage</span>
                        <span class="block text-kuet-400">Campus Events</span>
                        <span class="block">Seamlessly</span>
                    </h1>
                    
                    <p class="hero-desc">
                        Your one-stop platform for discovering, registering, and managing university events. 
                        From tech workshops to cultural festivals — everything at your fingertips.
                    </p>
                    
                <div class="hero-buttons">
                        <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket"></i>
                            Explore Events
                        </a>

                        <button class="btn btn-white btn-lg" onclick="scrollToSection('features')">
                            <i class="fas fa-play-circle"></i>
                            Learn More
                        </button>
                </div>

                </div>

                <!-- Right Side - Stats Panel -->
                <div class="hero-right lg:w-1/2 flex justify-center lg:justify-end">
                    <div class="stats-panel">
                        <div class="stats-panel-header">
                            <i class="fas fa-chart-bar"></i>
                            <span>Platform Overview</span>
                        </div>

                        <!-- Added hero-stats class so main.js scroll observer can animate counters -->
                        <div class="stats-panel-body hero-stats">
                            <div class="stat-panel-item">
                                <div class="stat-panel-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-panel-info">
                                    <div class="stat-panel-number" data-target="150">0</div>
                                    <div class="stat-panel-label">Events Hosted</div>
                                </div>
                            </div>
                            <div class="stat-panel-item">
                                <div class="stat-panel-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-panel-info">
                                    <div class="stat-panel-number" data-target="25">0</div>
                                    <div class="stat-panel-label">Active Clubs</div>
                                </div>
                            </div>
                            <div class="stat-panel-item">
                                <div class="stat-panel-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stat-panel-info">
                                    <div class="stat-panel-number" data-target="5000">0</div>
                                    <div class="stat-panel-label">Students</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="section-tag">About the Platform</span>
                <h2 class="section-title">Built for the KUET Community</h2>
                <p class="section-desc max-w-2xl mx-auto">
                    A centralized system designed to streamline event management across all university clubs and departments.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To simplify event discovery and participation for every KUET student through a unified digital platform.</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>Creating a vibrant campus culture where no student misses out on opportunities to learn, grow, and connect.</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Our Values</h3>
                    <p>Transparency, accessibility, and inclusivity in every event we help organize and promote.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="section-tag">Key Features</span>
                <h2 class="section-title">Everything You Need</h2>
                <p class="section-desc max-w-2xl mx-auto">
                    Powerful tools designed for students, club admins, and system administrators.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3>Event Discovery</h3>
                    <p>Browse all upcoming events with advanced filtering by category, date, and club.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3>Easy Registration</h3>
                    <p>One-click event registration with digital tickets and QR code check-ins.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Smart Calendar</h3>
                    <p>Personal event calendar with reminders and schedule management.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3>Approval Workflow</h3>
                    <p>Streamlined event approval process from submission to publication.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics Dashboard</h3>
                    <p>Comprehensive insights on event performance and participation trends.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-glow"></div>
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Real-time Notifications</h3>
                    <p>Instant alerts for approvals, reminders, and event updates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="section-tag">Access Portals</span>
                <h2 class="section-title">Choose Your Portal</h2>
                <p class="section-desc max-w-2xl mx-auto">
                    Secure login portals tailored for students, club administrators, and system administrators.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <!-- Student -->
                <div class="role-card student">
                    <div class="role-header">
                        <div class="role-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <span class="role-badge">Student</span>
                    </div>

                    <h3>Student Portal</h3>

                    <p class="role-desc">
                        Explore campus events, register for activities,
                        view schedules, and track your participation history.
                    </p>

                    <a href="{{ route('login.student') }}" class="btn btn-primary w-full mt-6">
                        Student Login
                    </a>

                </div>

                <!-- Club -->
                <div class="role-card club">
                    <div class="role-header">
                        <div class="role-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span class="role-badge">Club Admin</span>
                    </div>

                    <h3>Club Management Portal</h3>

                    <p class="role-desc">
                        Manage events, registrations, attendance records,
                        announcements, and club activities efficiently.
                    </p>

                    <a href="{{ route('login.organizer') }}" class="btn btn-primary w-full mt-6">
                        Club Login
                    </a>

                </div>

                <!-- Admin -->
                <div class="role-card admin">
                    <div class="role-header">
                        <div class="role-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="role-badge">Admin</span>
                    </div>

                    <h3>Administration Portal</h3>

                    <p class="role-desc">
                        Control approvals, users, venues, reports,
                        analytics, and overall platform operations.
                    </p>

                    <a href="{{ route('login.admin') }}" class="btn btn-primary w-full mt-6">
                        Admin Login
                    </a>

                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative overflow-hidden">
        <div class="cta-bg"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-lg text-white/80 mb-10 max-w-2xl mx-auto">
                Join thousands of KUET students and clubs already using the platform to discover and manage amazing events.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                    <i class="fas fa-rocket"></i>
                    Get Started Now
                </a>
                <button class="btn btn-outline-white btn-lg" onclick="scrollToSection('contact')">
                    <i class="fas fa-envelope"></i>
                    Contact Support
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="section-tag">Get in Touch</span>
                <h2 class="section-title">Contact Us</h2>
                <p class="section-desc max-w-2xl mx-auto">
                    Have questions or need assistance? We're here to help.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>support@kuet.ac.bd</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Phone</h3>
                    <p>+880 41-769468</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Location</h3>
                    <p>KUET, Khulna-9203</p>
                </div>
            </div>
        </div>
    </section>

@endsection