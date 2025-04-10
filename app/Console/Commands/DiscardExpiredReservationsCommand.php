<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DiscardExpiredReservationsCommand extends Command
{
    protected $signature = 'reservations:discard-expired';
    protected $description = 'Mark expired reservations as discarded and delete old discarded reservations';

    public function handle()
    {
        Log::info('Executing discard expired reservations command.');

        // Mark reservations as discarded
        $updatedCount = Reservation::where('status', 'active')
            ->where('appointment_time', '<', Carbon::now()->subHours(1))
            ->update([
                'status' => 'discarded',
                'discarded_at' => Carbon::now(),
            ]);

        if ($updatedCount > 0) {
            $this->info("$updatedCount reservations were marked as discarded.");
            Log::info("$updatedCount reservations were marked as discarded.");
        } else {
            $this->info("No reservations were eligible for marking as discarded.");
        }

        // Delete reservations that were discarded more than 1 hour ago
        $deletedCount = Reservation::where('status', 'discarded')
            ->where('discarded_at', '<', Carbon::now()->subHours(1))
            ->delete();

        if ($deletedCount > 0) {
            $this->info("$deletedCount discarded reservations were deleted.");
            Log::info("$deletedCount discarded reservations were deleted.");
        } else {
            $this->info("No discarded reservations to delete.");
        }
    }
}
