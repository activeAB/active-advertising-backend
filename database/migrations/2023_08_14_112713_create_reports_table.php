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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('start_date');
            $table->string('end_date');
            $table->string('totalOrder');
            $table->string('totalCustomer');
            $table->string('totalStock');
            $table->string('allocatedOrder');
            $table->string('approvedOrder');
            $table->string('completedOrder');
            $table->string('deliveredOrder');
            $table->string('totalCost');
            $table->string('totalProfit');
            $table->string('totalRevenue');
            $table->json('monday');
            $table->json('tuesday');
            $table->json('wednesday');
            $table->json('thursday');
            $table->json('friday');
            $table->json('saturday');
            $table->json('sunday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
