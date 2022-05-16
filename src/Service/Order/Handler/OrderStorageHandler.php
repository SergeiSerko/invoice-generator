<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\Storage\OrderStorageInterface;

/**
 * Handler used for storing order in some storage.
 */
class OrderStorageHandler extends AbstractOrderHandler
{
    private OrderStorageInterface $storage;

    public function __construct(OrderStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function handle(Order $order): Order
    {
        $this->store($order);
        return $this->handleNext($order);
    }

    private function store(Order $order): void
    {
        $this->storage->store($order);
        $order->setHandled(true);
    }
}