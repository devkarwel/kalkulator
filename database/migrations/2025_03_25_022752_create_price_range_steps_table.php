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
        Schema::create('price_range_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_range_id')->constrained()->onDelete('cascade');
            $table->decimal('min_width', 8, 2);
            $table->decimal('max_width', 8, 2);
            $table->decimal('min_height', 8, 2);
            $table->decimal('max_height', 8, 2);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_range_steps');
    }
};
