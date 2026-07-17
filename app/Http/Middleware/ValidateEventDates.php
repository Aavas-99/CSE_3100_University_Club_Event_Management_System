<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateEventDates
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $eventDate = $request->input('event_date');
            $regDeadline = $request->input('registration_deadline');
            $startTime = $request->input('start_time');
            $endTime = $request->input('end_time');

            if ($eventDate && $regDeadline && $regDeadline > $eventDate) {
                return back()->withErrors(['registration_deadline' => 'Registration deadline cannot be after the event date.'])->withInput();
            }

            if ($startTime && $endTime && $startTime >= $endTime) {
                return back()->withErrors(['start_time' => 'Start time must be before end time.'])->withInput();
            }
        }

        return $next($request);
    }
}
