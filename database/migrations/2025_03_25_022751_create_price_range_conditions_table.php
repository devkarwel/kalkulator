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
        Schema::create('price_range_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_range_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('attribute_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('attribute_value_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_collection_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_collection_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_collection_item_value_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_range_conditions');
    }
};
