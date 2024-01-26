<?php

namespace App\Models\Products;

use App\Models\Orders\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems(): BelongsToMany
    {
        return $this->belongsToMany(OrderItem::class);
    }
}
