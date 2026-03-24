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
        Schema::create('product_collection_item_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_collection_item_id');
            $table->string('name');
            $table->string('value');
            $table->string('label');
            $table->tinyInteger('sort_order')->default(0)->unsigned();
            $table->timestamps();

            $table->foreign('product_collection_item_id', 'pciv_item_fk')
                ->references('id')
                ->on('product_collection_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_collection_item_values');
    }
};
