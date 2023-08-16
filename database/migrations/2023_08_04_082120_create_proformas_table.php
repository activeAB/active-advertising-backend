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
        Schema::create('proformas', function (Blueprint $table) {

            $table->id();
            $table->string("invoice_date");
            $table->string("payment_request_number")->unique();
            $table->string("active_tin_nUmber");
            $table->string("active_account_number");
            $table->string("active_vat");
            $table->string("active_phone_number");
            $table->string("active_email");
            $table->string("client_name");
            $table->string("client_tin_number");
            $table->string("client_phone_number");
            $table->string("price_validity");
            $table->string("payment_method");
            $table->string("contact_person");
            $table->string('total_price');
            $table->string('total_profit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
