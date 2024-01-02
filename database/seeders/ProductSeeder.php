<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductVariation;
use App\Models\Products\ProductVariationType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type1 = ProductVariationType::factory()->create();
        $type2 = ProductVariationType::factory()->create();

        $categories = ProductCategory::factory()->count(5)->create();

        foreach ($categories as $category) {
            for ($i = 0; $i < 6; $i++) {
                Product::factory()
                    ->withImages()
                    ->for($category, 'category')
                    ->has(
                        ProductVariation::factory()->count(3)->for($type1, 'type'),
                        'variations'
                    )->has(
                        ProductVariation::factory()->count(3)->for($type2, 'type'),
                        'variations'
                    )->create();
            }
        }
    }
}
