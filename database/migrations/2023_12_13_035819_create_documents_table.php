<?php

use App\Models\Document;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('product_name');
            $table->integer('qty');
            $table->string('category');
            $table->text('description');
            $table->string('price');
            $table->datetime('manufacture_day')->nullable();
            $table->datetime('expiry_day')->nullable();
            $table->string('image')->nullable();
            $table->string('license_company');
            $table->string('license_product');
            $table->enum('status', [Document::AWAIT_APPROVAL, Document::APPROVED, Document::DENIED])->default(Document::AWAIT_APPROVAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
