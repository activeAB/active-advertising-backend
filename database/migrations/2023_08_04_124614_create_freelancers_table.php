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
        Schema::create('freelancers', function (Blueprint $table) {

            $table->id();
            $table->string('freelancer_first_name');
            $table->string('freelancer_last_name');
            $table->string('freelancer_address');
            $table->string('freelancer_phone_number');
            $table->string('freelancer_email')->unique();
            $table->string('freelancer_image_url');
            $table->string('freelancer_portfolio_link');
            $table->string('freelancer_order_status')->default('pending');
            $table->string('status')->default('Unallocated');
            $table->string('delete_role')->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
