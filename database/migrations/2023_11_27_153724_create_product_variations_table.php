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
            $table->decimal('price_modifier', 8, 2);
            $table->boolean('active')->default(true);
            $table->integer('order')->default(1);
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
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
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_variation_type_id']);
        });
    }
};
