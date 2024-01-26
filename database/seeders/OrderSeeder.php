<?php

namespace Database\Seeders;

use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::all()->each(function (OrderStatus $status) {
            Order::factory()->for($status, 'status')->withItems(2)->count(3)->create();
        });
    }
}
