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
        Schema::create('attribute_value_price_modifier_condition_attribute_value', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('attribute_value_price_modifier_condition_id');
            $table->unsignedBigInteger('attribute_value_id');

            $table->foreign('attribute_value_price_modifier_condition_id', 'avpmcav_condition_id_foreign')
                ->references('id')
                ->on('attribute_value_price_modifier_conditions')
                ->onDelete('cascade');

            $table->foreign('attribute_value_id', 'avpmcav_attr_value_id_foreign')
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
        Schema::dropIfExists('attribute_value_price_modifier_condition_attribute_value');
    }
};

