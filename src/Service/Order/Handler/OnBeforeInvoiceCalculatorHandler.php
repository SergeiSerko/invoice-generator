<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;

/**
 * Handler used for adding additional calculation logic before basic calculations were made.
 */
class OnBeforeInvoiceCalculatorHandler extends AbstractOrderHandler
{
    public function handle(Order $order): Order
    {
        $this->beforeCalculate($order);
        return $this->handleNext($order);
    }

    private function beforeCalculate(Order $order): Order
    {
        /** IMPLEMENT SOME LOGIC WHERE */
        return $order;
    }
}