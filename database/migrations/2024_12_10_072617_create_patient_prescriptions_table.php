<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientPrescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('patient_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('od')->nullable();
            $table->string('os')->nullable();
            $table->string('add')->nullable();
            $table->string('pd')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_prescriptions');
    }
}
