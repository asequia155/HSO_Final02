<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservation_histories', function (Blueprint $table) {
            $table->id();

            // Allow the reservation_id column to be nullable
            $table->foreignId('reservation_id')
                  ->nullable()
                  ->constrained('reservations')
                  ->onDelete('set null'); // Set reservation_id to NULL when the parent Reservation is deleted

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('gender');
            $table->text('remarks')->nullable();
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_histories');
    }
};
