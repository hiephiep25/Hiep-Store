<?php

use App\Models\Process;
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
        Schema::create('process', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('qty');
            $table->integer('store_id')->nullable();
            $table->enum('option', [Process::DESTROY, Process::DONATE, Process::COOKING, Process::SALEOFF])->default(Process::DESTROY);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process');
    }
};
