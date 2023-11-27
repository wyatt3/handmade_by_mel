<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Products\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'quantity',
        'base_price',
        'total',
        'product_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function variations()
    {
        return $this->belongsToMany(ProductVariation::class);
    }
}
