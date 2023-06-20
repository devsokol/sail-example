<?php

namespace App\Services;

use App\Models\Order;
use App\Enums\OrderStatus;

class OrderService
{
    /**
     * Create a new order.
     *
     * @param int $userId The ID of the user associated with the order.
     * @param int $goodId The ID of the good associated with the order.
     *
     * @return Order The created order instance.
     */
    public function create(int $userId, int $goodId): Order
    {
        $order = new Order();

        $order->status = OrderStatus::InProgress;
        $order->user_id = $userId;
        $order->good_id = $goodId;

        $order->save();

        return $order;
    }
}
