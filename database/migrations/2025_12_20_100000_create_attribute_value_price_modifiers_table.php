<?php

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
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
        Schema::create('attribute_value_price_modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_value_id')->constrained()->cascadeOnDelete();
            $table->decimal('value', 10, 2);
            $table->enum('type', array_column(PriceTypeModifier::cases(), 'value'))->default(PriceTypeModifier::PERCENT);
            $table->enum('action', array_column(PriceActionModifier::cases(), 'value'))->default(PriceActionModifier::ADD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_value_price_modifiers');
    }
};

