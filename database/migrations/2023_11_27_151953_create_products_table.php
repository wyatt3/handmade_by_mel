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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->string('sku')->unique()->index('sku');
            $table->boolean('active')->default(true);
            $table->bigInteger('product_category_id')->unsigned();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('products', function (Blueprint $table) {
            $table->dropIndex('sku');
            $table->dropForeign(['product_category_id']);
        });
    }
};
