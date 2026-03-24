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
        Schema::create('price_range_condition_attribute_value', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('price_range_condition_id');
            $table->unsignedBigInteger('attribute_value_id');

            $table->foreign('price_range_condition_id', 'prcav_condition_id_foreign')
                ->references('id')
                ->on('price_range_conditions')
                ->onDelete('cascade');

            $table->foreign('attribute_value_id', 'prcav_attr_value_id_foreign')
                ->references('id')
                ->on('attribute_values')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_range_condition_attribute_value');
    }
};
