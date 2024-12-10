<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePrescriptionFieldsFromPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['rx', 'od', 'os', 'add', 'pd']);
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('rx')->nullable();
            $table->string('od')->nullable();
            $table->string('os')->nullable();
            $table->string('add')->nullable();
            $table->string('pd')->nullable();
        });
    }
}
