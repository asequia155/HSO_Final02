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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('rx')->nullable(); // Prescription
            $table->string('od')->nullable(); // Right Eye
            $table->string('os')->nullable(); // Left Eye
            $table->decimal('add', 4, 2)->nullable(); // Addition (e.g., +0.50 to +3.50)
            $table->decimal('pd', 5, 2)->nullable(); // Pupillary Distance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['rx', 'od', 'os', 'add', 'pd']);
        });
    }
};
