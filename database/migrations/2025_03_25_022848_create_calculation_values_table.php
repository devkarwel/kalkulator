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
        Schema::create('calculation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_id')->constrained()->cascadeOnDelete();

            // Referencyjne ID (opcjonalne)
            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->unsignedBigInteger('attribute_value_id')->nullable();

            // Snapshot danych
            $table->string('attribute_name');
            $table->string('value_label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_values');
    }
};
