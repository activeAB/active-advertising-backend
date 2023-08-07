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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('item_description');
            $table->string('size');
            $table->string('quantity');
            $table->string('unit_price');
            $table->string('total_price');
            $table->string('vendor_name');
            $table->string('status');
            $table->string('status_description');
            $table->timestamps();
            $table->unsignedBigInteger('proforma_id');
            $table->foreign('proforma_id')
                ->references('id')
                ->on('proformas')
                ->onDelete('cascade');
            $table->unsignedBigInteger('freelancer_id');
            $table->foreign('freelancer_id')
                ->references('id')
                ->on('freelancers')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
