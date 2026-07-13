<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
       
    // Show ticket details page (with QR preview)
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $registration = $ticket->registration;

        // Authorization
        if (!$user || (
            $user->id !== $registration->user_id &&
            $user->role !== 'admin' &&
            ($user->role !== 'organizer' || $user->organizerClub?->id !== $registration->event->club_id)
        )) {
            abort(403);
        }

        return view('tickets.show', compact('ticket', 'registration'));
    }


    // Download PDF ticket
    public function download(Ticket $ticket)
    {
        $user = Auth::user();
        $registration = $ticket->registration;

        if (!$user || (
            $user->id !== $registration->user_id &&
            $user->role !== 'admin' &&
            ($user->role !== 'organizer' || $user->organizerClub?->id !== $registration->event->club_id)
        )) {
            abort(403);
        }

        return $this->ticketService->downloadTicket($ticket);
    }
}