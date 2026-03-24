<?php

use App\Models\AttributeValue;
use App\Models\PriceRangeModifier;
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
        Schema::create('attr_vpr_modifier', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PriceRangeModifier::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(AttributeValue::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attr_vpr_modifier');
    }
};
