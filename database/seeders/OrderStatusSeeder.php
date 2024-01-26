<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'New',
            ],
            [
                'name' => 'Shipped',
            ],
            [
                'name' => 'Completed',
            ],
            [
                'name' => 'Cancelled',
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\Orders\OrderStatus::create($status);
        }
    }
}
