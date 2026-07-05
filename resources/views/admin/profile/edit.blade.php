@extends('layouts.app')

@section('title', 'Edit Admin Profile | KUET EMS')

@section('content')
<div class="bg-slate-100 py-12">
    <div class="max-w-3xl mx-auto px-6">
        @include('partials.flash')
        <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Edit Admin Profile</h1>
                <p class="mt-2 text-slate-500">Update your administrator details. Leave the password blank to keep it unchanged.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">New Password</label>
                        <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-kuet-500 focus:ring-kuet-500">
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white shadow-lg shadow-kuet-500/20 hover:bg-kuet-800">Update Profile</button>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-2xl bg-kuet-700 px-6 py-3 text-white shadow-lg shadow-kuet-500/20 hover:bg-kuet-800">Return to dashboard</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
