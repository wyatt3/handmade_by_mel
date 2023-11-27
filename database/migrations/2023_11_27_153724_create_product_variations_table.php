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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->string('sku')->unique()->index('sku');
            $table->string('parent_sku')->index('parent_sku');
            $table->foreign('parent_sku')->references('sku')->on('products');
            $table->boolean('active')->default(true);
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('product_variation_type_id')->unsigned();
            $table->foreign('product_variation_type_id')->references('id')->on('product_variation_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('product_variations', function (Blueprint $table) {
            $table->dropIndex('sku');
            $table->dropIndex('parent_sku');
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_variation_type_id']);
        });
    }
};
