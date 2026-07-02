<nav class="navbar" id="navbar">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="logo-container">
                <img src="{{ asset('images/kuet-logo.png') }}" alt="KUET Logo" class="h-12 w-auto logo-img">
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-bold text-kuet-900 tracking-tight">Event Management</span>
                <span class="text-xs text-slate-400 font-medium tracking-wide">Khulna University of Engineering & Technology</span>
            </div>
        </a>

        <!-- Nav Links -->
        <div class="hidden md:flex items-center gap-1">
            <a href="#hero" class="nav-link active">Home</a>
            <a href="#about" class="nav-link">About</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#roles" class="nav-link">Roles</a>
            <a href="#contact" class="nav-link">Contact</a>
        </div>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-3">
              <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
              <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        </div>

    </div>
</nav>