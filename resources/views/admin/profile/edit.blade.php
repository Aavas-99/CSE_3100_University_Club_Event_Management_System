@extends('layouts.app')

@section('title', 'Edit Admin Profile | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fas fa-shield-alt text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Admin Profile</h1>
                    <p class="text-slate-500 text-sm mt-1">Update your administrator details</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            @csrf
            
            <div class="p-8">
                <!-- Avatar Section -->
                <div class="flex items-center gap-6 mb-8 pb-8 border-b border-slate-100">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-purple-500/25">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                            <span class="px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-xs font-bold">Admin</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        <p class="text-xs text-slate-400 mt-1">Administrator since {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
                
                <!-- Admin Info -->
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">1</span>
                    Account Information
                </h2>
                
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                </div>
                
                <!-- Security -->
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold">2</span>
                    Change Password
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                            placeholder="Leave blank to keep current">
                        <p class="text-xs text-slate-400 mt-1">Min 8 characters with uppercase, lowercase, number & symbol</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                            placeholder="Confirm new password">
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Dashboard
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-purple-700 text-white text-sm font-semibold hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg shadow-purple-500/20 btn-shine flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
