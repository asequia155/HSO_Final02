<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use App\Models\Reservation;
use Carbon\Carbon;

class DiscardExpiredReservations
{
    public function handle($request, Closure $next)
    {
        Log::info('Middleware: Checking and discarding expired reservations.');

        // Mark expired reservations as discarded
        Reservation::where('status', 'active')
            ->where('appointment_time', '<', Carbon::now()->subHours(1))
            ->update([
                'status' => 'discarded',
                'discarded_at' => Carbon::now(),
            ]);

        // Delete reservations that were discarded more than 1 hour ago
        Reservation::where('status', 'discarded')
            ->where('discarded_at', '<', Carbon::now()->subHours(1))
            ->delete();

        return $next($request);
    }
}
