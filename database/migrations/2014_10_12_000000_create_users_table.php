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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_email')->unique();
            $table->string('user_role');
            $table->string('delete_role')->default('no');
            $table->string('user_phone_number');
            $table->string('user_address');
            $table->string('user_image_url');
            $table->string('user_password');
            $table->string('status')->default('Unallocated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
