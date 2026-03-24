<?php

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->boolean('required')->default(false);
            $table->enum('input_type', array_column(AttributeInputType::cases(), 'value'))
                ->default(AttributeInputType::FIELD_INPUT);
            $table->enum('input_variant', array_column(AttributeInputVariant::cases(), 'value'))
                ->default(AttributeInputVariant::INPUT_TEXT)
                ->nullable();
            $table->string('name')->nullable(false);
            $table->string('label')->nullable()->default(null);
            $table->enum('column_side', array_column(AttributeSideColumn::cases(), 'value'))
                ->nullable(false)
                ->default(AttributeSideColumn::COLUMN_LEFT);
            $table->tinyInteger('nr_step')->default(0)->unsigned();
            $table->tinyInteger('sort_order')->default(0)->unsigned();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
