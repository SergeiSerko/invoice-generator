<?php

namespace App\Service\Order\Resolver;

use App\Service\Order\DTO\Order;
use App\Service\Order\Exception\OrderNotResolvedException;

/**
 * Provides interface for some order resolver
 */
interface OrderResolverInterface
{
    /**
     * @throws OrderNotResolvedException
     */
    public function resolve(Order $invoice): Order;
}