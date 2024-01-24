<?php

namespace App\Services;

use App\Mail\NewOrder;
use App\Mail\OrderConfirmation;
use App\Mail\ShipmentNotification;
use App\Models\Orders\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use App\Models\Orders\Shipment;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Mail;

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
        Mail::to(env('ADMIN_EMAIL'))
            ->send(new NewOrder($order));
        Mail::to($order->customer->email)
            ->send(new OrderConfirmation($order));
        return $order->fresh();
    }

    /**
     * recalculate order and order item totals
     *
     * @param Order $order
     * @return void
     */
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

    /**
     * Mark order as shipped
     *
     * @param Order $order
     * @param string $carrier
     * @param string $trackingNumber
     * @return Shipment
     */
    public function markShipped(Order $order, string $carrier, string $trackingNumber): Shipment
    {
        $order->update([
            'status_id' => OrderStatus::findOrFail(config('orders.statuses.shipped'))->getKey(),
        ]);
        $shipment = $order->shipments()->create([
            'carrier' => $carrier,
            'tracking_number' => $trackingNumber,
            'shipment_date' => now(),
        ]);

        Mail::to($shipment->order->customer->email)
            ->send(new ShipmentNotification($shipment));

        return $shipment;
    }

    /**
     * Mark order as completed
     *
     * @param Order $order
     * @return Order
     */
    public function markCompleted(Order $order): Order
    {
        $order->update([
            'status_id' => OrderStatus::findOrFail(config('orders.statuses.completed'))->getKey(),
        ]);
        return $order->fresh();
    }

    /**
     * Cancel order
     *
     * @param Order $order
     * @return Order
     */
    public function cancelOrder(Order $order): Order
    {
        $order->update([
            'status_id' => OrderStatus::findOrFail(config('orders.statuses.cancelled'))->getKey(),
        ]);
        return $order->fresh();
    }
}
