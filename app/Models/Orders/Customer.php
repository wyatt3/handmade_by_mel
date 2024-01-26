<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'city',
        'state',
        'postal_code',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
