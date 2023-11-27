<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
