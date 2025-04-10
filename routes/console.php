<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Inspire command to display a motivational quote
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Define additional custom commands
Artisan::command('reservations:discard-expired', function () {
    $this->call('reservations:discard-expired');
    $this->info('Expired reservations have been processed.');
})->purpose('Mark expired reservations as discarded and delete old discarded reservations.');

