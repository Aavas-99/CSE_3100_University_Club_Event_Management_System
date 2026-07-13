<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $ticketData['ticket_number'] }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; padding: 16px; color: #1e293b; font-size: 9px; }
        .ticket { max-width: 440px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #16a34a, #15803d); padding: 14px; text-align: center; color: #fff; }
        .header h1 { font-size: 12px; font-weight: 700; }
        .header p { font-size: 8px; opacity: 0.9; margin-top: 2px; }
        .body { padding: 14px; }
        .code { text-align: center; font-size: 18px; font-weight: 800; color: #16a34a; letter-spacing: 2px; margin-bottom: 10px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px; }
        .item { background: #f8fafc; padding: 6px 8px; border-radius: 6px; }
        .item .label { font-size: 6px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .item .value { font-size: 9px; font-weight: 600; color: #1e293b; margin-top: 1px; }
        .qr { text-align: center; padding: 10px; background: #f0fdf4; border-radius: 8px; margin-bottom: 8px; }
        .qr img { width: 90px; height: 90px; }
        .qr p { font-size: 7px; color: #16a34a; margin-top: 4px; }
        .footer { text-align: center; padding: 8px 14px; border-top: 1px solid #e2e8f0; font-size: 6px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>KUET Event Management System</h1>
            <p>Official Event Ticket</p>
        </div>
        <div class="body">
            <div class="code">{{ $ticketData['ticket_number'] }}</div>
            <div class="grid">
                <div class="item"><div class="label">Event</div><div class="value">{{ \Illuminate\Support\Str::limit($ticketData['event'], 30) }}</div></div>
                <div class="item"><div class="label">Date</div><div class="value">{{ $registration->event->event_date->format('M d, Y') }}</div></div>
                <div class="item"><div class="label">Time</div><div class="value">{{ \Carbon\Carbon::parse($registration->event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($registration->event->end_time)->format('g:i A') }}</div></div>
                <div class="item"><div class="label">Venue</div><div class="value">{{ \Illuminate\Support\Str::limit($ticketData['venue'], 30) }}</div></div>
                <div class="item"><div class="label">Attendee</div><div class="value">{{ $ticketData['student'] }}</div></div>
                <div class="item"><div class="label">Student ID</div><div class="value">{{ $ticketData['student_id'] ?? 'N/A' }}</div></div>
            </div>
            <div class="qr">
                <img src="{{ $qrBase64 }}" alt="QR Code">
                <p>Scan at entrance for check-in</p>
            </div>
        </div>
        <div class="footer">
            <p>Non-transferable | Valid only for registered attendee</p>
            <p><strong>KUET EMS</strong> | Khulna University of Engineering & Technology</p>
        </div>
    </div>
</body>
</html>