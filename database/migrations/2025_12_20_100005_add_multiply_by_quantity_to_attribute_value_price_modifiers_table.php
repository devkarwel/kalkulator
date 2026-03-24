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
        Schema::table('attribute_value_price_modifiers', function (Blueprint $table) {
            $table->boolean('multiply_by_quantity')->default(false)->after('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_value_price_modifiers', function (Blueprint $table) {
            $table->dropColumn('multiply_by_quantity');
        });
    }
};


