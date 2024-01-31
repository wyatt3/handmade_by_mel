<?php

namespace App\Models\Orders;

use App\Models\Orders\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'address_type',
        'line_1',
        'line_2',
        'line_3',
        'line_4',
        'city',
        'state',
        'postal_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
