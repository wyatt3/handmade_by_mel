<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'sku',
        'parent_sku',
        'active',
        'product_id',
        'product_variation_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'sku', 'sku');
    }
}
