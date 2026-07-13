@extends('layouts.app')

@section('title', 'Ticket ' . $ticket->ticket_number . ' | KUET EMS')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-kuet-100 flex items-center justify-center text-kuet-600">
                    <i class="fas fa-ticket-alt text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Your Ticket</h1>
                    <p class="text-slate-500 text-sm mt-1">{{ $registration->event->title }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-lg">
            <div class="bg-gradient-to-r from-kuet-600 to-kuet-700 p-6 text-center text-white">
                <h2 class="text-2xl font-bold tracking-widest">{{ $ticket->ticket_number }}</h2>
                <p class="text-kuet-100 text-xs mt-1">Official KUET Event Ticket</p>
            </div>
            
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Event</p>
                            <p class="text-base font-bold text-slate-900">{{ $registration->event->title }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Date & Time</p>
                            <p class="text-sm text-slate-700">{{ $registration->event->event_date->format('l, F d, Y') }}</p>
                            <p class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($registration->event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($registration->event->end_time)->format('g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Venue</p>
                            <p class="text-sm text-slate-700">{{ $registration->event->venue }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Attendee</p>
                            <p class="text-sm text-slate-700 font-medium">{{ $registration->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $registration->user->student_id }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center bg-slate-50 rounded-2xl p-4">
                        @if($ticket->qr_code_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($ticket->qr_code_image))
                            <div class="bg-white p-3 rounded-xl shadow-sm">
                                {!! file_get_contents(storage_path('app/public/' . $ticket->qr_code_image)) !!}
                            </div>
                        @else
                            <div class="w-40 h-40 bg-slate-200 rounded-xl flex items-center justify-center">
                                <i class="fas fa-qrcode text-4xl text-slate-400"></i>
                            </div>
                        @endif
                        <p class="text-xs text-slate-500 text-center mt-3">Scan at the entrance for check-in</p>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('tickets.download', $ticket) }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-kuet-600 text-white text-sm font-semibold hover:bg-kuet-700 transition-all shadow-lg shadow-kuet-500/20">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a href="{{ route('events.show', $registration->event) }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-white transition-all">
                    <i class="fas fa-arrow-left"></i> Back to Event
                </a>
            </div>
        </div>
    </div>
</div>
@endsection