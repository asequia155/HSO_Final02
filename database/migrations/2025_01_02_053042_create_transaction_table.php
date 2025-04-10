<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable(); // Customer details (optional)
            $table->decimal('total_amount', 10, 2); // Total transaction amount
            $table->decimal('discount_amount', 10, 2)->nullable(); // Discount, if any
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
