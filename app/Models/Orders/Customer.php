<?php

namespace App\Models\Orders;

use App\Enums\AddressType;
use App\Models\Orders\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function getShippingAddressAttribute(): Address
    {
        return $this->addresses()->where('address_type', AddressType::Shipping)->first();
    }

    public function getBillingAddressAttribute(): Address
    {
        return $this->addresses()->where('address_type', AddressType::Billing)->first();
    }
}
