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
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->enum('payment_type', [OnlineOrder::ONLINE_PAYMENT, OnlineOrder::PAY_LATER])->default(OnlineOrder::ONLINE_PAYMENT);
            $table->datetime('delivery_date')->nullable();
            $table->datetime('actual_delivery_date')->nullable();
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
