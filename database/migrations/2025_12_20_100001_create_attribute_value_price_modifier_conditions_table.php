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
        Schema::create('attribute_value_price_modifier_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_value_price_modifier_id');
            $table->foreign('attribute_value_price_modifier_id', 'avpmc_modifier_id_foreign')
                ->references('id')
                ->on('attribute_value_price_modifiers')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'avpmc_product_id_foreign')
                ->references('id')
                ->on('products')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->foreign('attribute_id', 'avpmc_attribute_id_foreign')
                ->references('id')
                ->on('attributes')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('product_collection_id')->nullable();
            $table->foreign('product_collection_id', 'avpmc_collection_id_foreign')
                ->references('id')
                ->on('product_collections')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('product_collection_item_id')->nullable();
            $table->foreign('product_collection_item_id', 'avpmc_item_id_foreign')
                ->references('id')
                ->on('product_collection_items')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('product_collection_item_value_id')->nullable();
            $table->foreign('product_collection_item_value_id', 'avpmc_value_id_foreign')
                ->references('id')
                ->on('product_collection_item_values')
                ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_value_price_modifier_conditions');
    }
};

