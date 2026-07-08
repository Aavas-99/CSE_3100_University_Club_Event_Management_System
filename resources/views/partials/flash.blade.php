@if (session('success'))
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 flex items-start gap-3 animate-fade-in">
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
            <i class="fas fa-check text-emerald-600 text-sm"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-emerald-900">Success</h4>
            <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
        <button onclick="this.closest('.mb-6').remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-6 py-4 flex items-start gap-3 animate-fade-in">
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
            <i class="fas fa-exclamation text-red-600 text-sm"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-red-900">Error</h4>
            <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
        </div>
        <button onclick="this.closest('.mb-6').remove()" class="text-red-400 hover:text-red-600 transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-6 py-4 animate-fade-in">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-red-900">Please fix the following errors:</h4>
                <ul class="mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-700 flex items-center gap-2">
                            <i class="fas fa-circle text-[6px]"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-6 py-4 flex items-start gap-3 animate-fade-in">
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
            <i class="fas fa-exclamation text-amber-600 text-sm"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-amber-900">Warning</h4>
            <p class="text-sm text-amber-700 mt-0.5">{{ session('warning') }}</p>
        </div>
    </div>
@endif