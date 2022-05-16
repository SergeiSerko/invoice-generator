<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;

/**
 * Provides interface for order handlers of chain-of-responsibility.
 */
interface OrderHandlerInterface
{
    public function handle(Order $order): Order;

    public function setSuccessor(?OrderHandlerInterface $successor): OrderHandlerInterface;
}