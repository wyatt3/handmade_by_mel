<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_modifier',
        'image',
        'active',
        'order',
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

    public function orderItems()
    {
        return $this->belongsToMany(OrderItemVariation::class);
    }
}
