<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Batch;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class CheckBatchExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for batches nearing expiration and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Batch expiry command started.');
        // Define the threshold for near-expiration (e.g., 7 days)
        $threshold = Carbon::now()->addDays(7);

        // Find batches nearing expiration
        $batches = Batch::where('expiry_date', '<=', $threshold)
                        ->where('expiry_date', '>=', Carbon::now())
                        ->get();

                        Log::info('Batches nearing expiry: ', ['count' => $batches->count()]);

        foreach ($batches as $batch) {
            // Check if a notification already exists for this batch
            $existingNotification = Notification::where('title', 'Batch Near Expiration')
                                                ->where('message', 'like', "%Batch {$batch->batch_number}%")
                                                ->exists();

            if (!$existingNotification) {
                // Create a notification
                Notification::create([
                    'title' => 'Batch Near Expiration',
                    'message' => "Batch {$batch->batch_number} of product {$batch->product->name} is nearing expiration (Expiry: " . Carbon::parse($batch->expiry_date)->toFormattedDateString() . ").",
                    'is_read' => false,
                ]);
            }
        }

        $this->info('Batch expiry check completed.');
    }
}
