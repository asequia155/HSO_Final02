<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for users table
    $table->string('first_name'); // Patient's first name
    $table->string('last_name'); // Patient's last name
    $table->string('phone'); // Patient's phone number
    $table->string('email'); // Patient's email (unique if necessary)
    $table->string('gender'); // Patient's gender
    $table->date('date_of_birth')->nullable();
    $table->string('occupation')->nullable();
    $table->text('address')->nullable();
    $table->text('remarks')->nullable(); // Additional remarks
    $table->date('appointment_date'); // Appointment date
    $table->time('appointment_time'); // Appointment time
    $table->timestamps(); // Created at and updated at

    // Foreign key constraint for user_id
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('set null');
});
    }



    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
