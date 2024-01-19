<?php

namespace App\Services;

use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use App\Models\Products\Product;

class OrderService
{
    public function createOrder(Customer $customer, array $items): Order
    {
        // Create order
        $order = Order::create([
            'customer_id' => $customer->getKey(),
            'status_id' => OrderStatus::findOrFail(config('orders.statuses.created'))->getKey()
        ]);
        foreach ($items as $item) {
            // Create order item
            $product = Product::findOrFail($item['product']['id']);
            $orderItem = $order->items()->create([
                'quantity' => $item['quantity'],
                'base_price' => $product->sale_price ?? $product->price,
                'product_id' => $product->getKey(),
            ]);

            // Create order item variation
            foreach ($item['variations'] as $variation) {
                $orderItem->variations()->attach($variation['id']);
            }
        }
        $this->recalculateTotals($order);
        return $order->fresh();
    }

    public function recalculateTotals(Order $order): void
    {
        $total = 0;
        foreach ($order->items as $item) {
            $total += $itemTotal = ($item->base_price + $item->variations->sum('price_modifier')) * $item->quantity;
            $item->update([
                'total' => $itemTotal,
            ]);
        }
        $order->update([
            'total' => $total,
        ]);
    }
}
