<footer class="bg-kuet-950 text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-12 mb-12">
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/kuet-logo.png') }}" alt="KUET Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold">KUET EMS</span>
                </div>
                <p class="text-slate-400 leading-relaxed max-w-md">
                    The official Event Management System for Khulna University of Engineering & Technology. 
                    Connecting students with campus events since 2026.
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-lg">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}#hero" class="text-slate-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('home') }}#about" class="text-slate-400 hover:text-white transition-colors">About</a></li>
                    <li><a href="{{ route('home') }}#features" class="text-slate-400 hover:text-white transition-colors">Features</a></li>
                    <li><a href="{{ route('home') }}#roles" class="text-slate-400 hover:text-white transition-colors">Roles</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">&copy; 2026 Khulna University of Engineering & Technology. All rights reserved.</p>
        </div>
    </div>
</footer>