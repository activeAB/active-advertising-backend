<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item_description');
            $table->integer('quantity');
            $table->double('unit_price', 10, 2);
            $table->double('total_price', 10, 2);
            $table->string('unit_measurement');
            $table->string('purchase_date');
            $table->date('expire_date');
            $table->string('dealer_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
