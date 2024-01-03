<?php

use App\Models\OnlineOrder;
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
        Schema::create('online_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->datetime('order_date');
            $table->datetime('delivery_date');
            $table->date('actual_delivery_date')->nullable();
            $table->enum('status', [OnlineOrder::IN_PROGRESS, OnlineOrder::COMPLETE, OnlineOrder::PENDING])->default(OnlineOrder::IN_PROGRESS);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_orders');
    }
};
