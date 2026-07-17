<footer class="bg-slate-900 text-white relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-kuet-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-12">
            <!-- Brand -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/kuet-logo.png') }}" alt="KUET" class="h-12 w-auto rounded-lg bg-white/10 p-1">
                    <div>
                        <h3 class="text-xl font-bold">KUET EMS</h3>
                        <p class="text-xs text-slate-400">Event Management System</p>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">
                    The official platform for managing and discovering events at Khulna University of Engineering & Technology.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider text-slate-300 mb-4">Platform</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('events.index') }}" class="text-slate-400 hover:text-kuet-400 text-sm transition-colors">Browse Events</a></li>
                    <li><a href="{{ route('clubs.index') }}" class="text-slate-400 hover:text-kuet-400 text-sm transition-colors">Clubs</a></li>
                    <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-kuet-400 text-sm transition-colors">Register</a></li>
                    <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-kuet-400 text-sm transition-colors">Sign In</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider text-slate-300 mb-4">Contact</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-slate-400 text-sm">
                        <i class="fas fa-map-marker-alt mt-1 text-kuet-500"></i>
                        <span>KUET, Fulbarigate, Khulna-9203</span>
                    </li>
                    <li class="flex items-center gap-3 text-slate-400 text-sm">
                        <i class="fas fa-phone text-kuet-500"></i>
                        <span>+880 41-769468</span>
                    </li>
                    <li class="flex items-center gap-3 text-slate-400 text-sm">
                        <i class="fas fa-envelope text-kuet-500"></i>
                        <span>support@kuet.ac.bd</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Khulna University of Engineering & Technology. All rights reserved.
            </p>
            <p class="text-slate-600 text-xs">
                Designed & Developed with <i class="fas fa-heart text-red-500 mx-1"></i> for KUET
            </p>
        </div>
    </div>
</footer>