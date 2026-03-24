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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyInteger('sort_order')->default(0)->unsigned();
            $table->string('width_attribute')->nullable()->default(null);
            $table->string('height_attribute')->nullable()->default(null);
            $table->string('depth_attribute')->nullable()->default(null);
            $table->string('quantity_attribute')->nullable()->default(null);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
