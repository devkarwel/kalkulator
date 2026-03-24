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
            $table->decimal('min_width', 10, 2)->nullable()->after('product_collection_item_value_id');
            $table->decimal('max_width', 10, 2)->nullable()->after('min_width');
            $table->integer('min_quantity')->nullable()->after('max_width');
            $table->integer('max_quantity')->nullable()->after('min_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_value_price_modifier_conditions', function (Blueprint $table) {
            $table->dropColumn(['min_width', 'max_width', 'min_quantity', 'max_quantity']);
        });
    }
};


