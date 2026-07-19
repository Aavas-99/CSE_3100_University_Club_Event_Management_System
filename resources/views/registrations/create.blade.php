@extends('layouts.app')

@section('title', 'Register for ' . $event->title . ' | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <!-- Page Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-kuet-100 flex items-center justify-center text-kuet-600">
                    <i class="fas fa-ticket-alt text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Event Registration</h1>
                    <p class="text-slate-500 text-sm mt-1">Complete your registration for {{ $event->title }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <div class="grid lg:grid-cols-5 gap-8">
            <!-- Event Summary -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-kuet-600 to-kuet-800 relative">
                        <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.4%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold backdrop-blur-sm">
                                {{ $event->event_type }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $event->title }}</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ Str::limit($event->description, 120) }}</p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-kuet-50 flex items-center justify-center text-kuet-600">
                                    <i class="fas fa-building text-xs"></i>
                                </div>
                                <span class="text-slate-600">{{ $event->club->name }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-calendar text-xs"></i>
                                </div>
                                <span class="text-slate-600">{{ $event->event_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-map-marker-alt text-xs"></i>
                                </div>
                                <span class="text-slate-600">{{ $event->venue }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                    <i class="fas fa-chair text-xs"></i>
                                </div>
                                <span class="{{ $event->remaining_seats > 10 ? 'text-emerald-600' : 'text-amber-600' }} font-semibold">
                                    {{ $event->remaining_seats }} seats remaining
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4">Your Information</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Name</span>
                            <span class="font-medium text-slate-900">{{ $user->name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Email</span>
                            <span class="font-medium text-slate-900">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Student ID</span>
                            <span class="font-medium text-slate-900">{{ $user->student_id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Department</span>
                            <span class="font-medium text-slate-900">{{ $user->department ?? 'Not set' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Phone</span>
                            <span class="font-medium text-slate-900">{{ $user->phone ?? 'Not set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="lg:col-span-3">
                <form action="{{ route('registrations.store', $event) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="p-8">
                        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-kuet-100 text-kuet-600 flex items-center justify-center text-sm font-bold">1</span>
                            Confirm Your Details
                        </h2>
                        
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                    placeholder="e.g., student@kuet.ac.bd">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white input-focus transition-all"
                                    placeholder="e.g., +880 1XXX-XXXXXX">
                            </div>
                        </div>
                        
                        <div class="mt-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900">What happens next?</p>
                                    <p class="text-sm text-blue-700 mt-1">Once submitted, your request will be reviewed by the event organizer. Approved registrations receive a digital ticket automatically.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('events.show', $event) }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                            Cancel registration
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-kuet-600 to-kuet-700 text-white text-sm font-semibold hover:from-kuet-700 hover:to-kuet-800 transition-all shadow-lg shadow-kuet-500/20 btn-shine flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Submit Registration Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
