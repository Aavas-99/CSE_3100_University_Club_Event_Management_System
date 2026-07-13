<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketService
{
    public function generateTicket(Registration $registration): Ticket
    {
        if (empty($registration->ticket_number)) {
            $registration->ticket_number = 'EV' . now()->format('Ymd') . str_pad((string) ($registration->id), 4, '0', STR_PAD_LEFT);
            $registration->save();
        }

        $ticketData = [
            'ticket_number' => $registration->ticket_number,
            'event' => $registration->event->title,
            'date' => $registration->event->event_date->format('Y-m-d'),
            'venue' => $registration->event->venue,
            'student' => $registration->user->name,
            'student_id' => $registration->user->student_id,
        ];

        $jsonPayload = json_encode($ticketData);

        // Generate QR as SVG
        $qrFileName = 'qr_' . $registration->ticket_number . '.svg';
        $qrPath = 'tickets/qrcodes/' . $qrFileName;
        
        Storage::disk('public')->makeDirectory('tickets/qrcodes');
        
        $qrImage = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('M')
            ->margin(1)
            ->generate($jsonPayload);

        Storage::disk('public')->put($qrPath, $qrImage);

        // Convert SVG to base64 for PDF embedding
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrImage);

        // Generate PDF
        $pdfFileName = 'ticket_' . $registration->ticket_number . '.pdf';
        $pdfPath = 'tickets/pdfs/' . $pdfFileName;

        Storage::disk('public')->makeDirectory('tickets/pdfs');

        $pdf = Pdf::loadView('tickets.pdf', [
            'registration' => $registration,
            'qrBase64' => $qrBase64, // Pass base64 string
            'ticketData' => $ticketData,
        ]);

        $pdf->setPaper([0, 0, 480, 680]);

        Storage::disk('public')->put($pdfPath, $pdf->output());

        return Ticket::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'qr_code' => $jsonPayload,
                'qr_code_image' => $qrPath,
                'pdf_path' => $pdfPath,
                'issued_at' => now(),
            ]
        );
    }

    public function downloadTicket(Ticket $ticket)
    {
        if (empty($ticket->pdf_path) || !Storage::disk('public')->exists($ticket->pdf_path)) {
            $ticket = $this->generateTicket($ticket->registration);
        }

        return response()->download(
            storage_path('app/public/' . $ticket->pdf_path),
            'KUET_Ticket_' . $ticket->ticket_number . '.pdf'
        );
    }
}