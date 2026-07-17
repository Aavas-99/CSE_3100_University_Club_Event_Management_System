@extends('layouts.app')

@section('title', 'Edit Profile | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-cog text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit Profile</h1>
                    <p class="text-slate-500 text-sm mt-1">Update your personal information</p>
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
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-kuet-400 to-kuet-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-kuet-500/25">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                        <p class="text-sm text-slate-500 capitalize">{{ $user->role }} Account</p>
                        <p class="text-xs text-slate-400 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
                
                <!-- Personal Info -->
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-kuet-100 text-kuet-600 flex items-center justify-center text-sm font-bold">1</span>
                    Personal Information
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Student ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="student_id" value="{{ old('student_id', $user->student_id) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="department" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all appearance-none cursor-pointer">
                                <option value="">Select Department</option>
                                @foreach(['EEE','CSE','CE','ME','ECE','IEM','ESE','BME','URP','LE','TE','BECM','ARCH','MSE','CHE','MTE'] as $dept)
                                    <option value="{{ $dept }}" {{ old('department', $user->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Phone <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all">
                    </div>
                </div>
                
                <!-- Security -->
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold">2</span>
                    Security
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6" x-data="{ showPass: false, showConfirm: false }">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                placeholder="Leave blank to keep current">
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                placeholder="Confirm new password">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Dashboard
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white text-sm font-semibold hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/20 btn-shine flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
