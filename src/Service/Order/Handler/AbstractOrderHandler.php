<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;

abstract class AbstractOrderHandler implements OrderHandlerInterface
{
    protected ?OrderHandlerInterface $successor = null;

    final public function setSuccessor(?OrderHandlerInterface $successor): AbstractOrderHandler
    {
        $this->successor = $successor;
        return $this;
    }

    final public function handleNext(Order $order): Order
    {
        if ($this->successor) {
            return $this->successor->handle($order);
        }
        return $order;
    }

    abstract public function handle(Order $order): Order;
}