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
        Schema::table('attribute_value_price_modifier_conditions', function (Blueprint $table) {
            $table->string('operator', 10)->default('=')->after('attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_value_price_modifier_conditions', function (Blueprint $table) {
            $table->dropColumn('operator');
        });
    }
};


