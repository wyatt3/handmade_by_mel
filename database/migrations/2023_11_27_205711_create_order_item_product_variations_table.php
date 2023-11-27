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
        Schema::create('order_item_product_variation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('order_item_id')->unsigned();
            $table->foreign('order_item_id')->references('id')->on('order_items')->cascadeOnDelete();
            $table->bigInteger('product_variation_id')->unsigned();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_product_variation', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropForeign(['product_variation_id']);
        });
    }
};
