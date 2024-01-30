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
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'city',
        'state',
        'postal_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
