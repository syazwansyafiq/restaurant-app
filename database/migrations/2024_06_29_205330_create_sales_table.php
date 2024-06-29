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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('total_amount')->nullable()->default('0');
            $table->string('order_count')->nullable()->default('0');
            $table->string('paid_amount')->nullable()->default('0');
            $table->string('average_amount')->nullable()->default('0');
            $table->string('latest_order')->nullable()->default('0');
            $table->string('today_amount')->nullable()->default('0');
            $table->string('week_amount')->nullable()->default('0');
            $table->string('month_amount')->nullable()->default('0');
            $table->string('year_amount')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
