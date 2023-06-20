<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether order can update, delete the model.
     */
    public function check(User $user, Order $order): bool
    {
        return $order->user_id === $user->id;
    }
}
