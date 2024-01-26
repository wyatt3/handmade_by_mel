<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }
}
