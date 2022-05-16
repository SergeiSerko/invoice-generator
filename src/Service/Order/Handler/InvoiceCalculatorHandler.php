<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\InvoiceCalculator\InvoiceCalculatorInterface;

/**
 * Handler used for basic invoice calculation
 */
class InvoiceCalculatorHandler extends AbstractOrderHandler
{
    private InvoiceCalculatorInterface $calculator;

    public function __construct(InvoiceCalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(Order $order): Order
    {
        $this->calculate($order);
        return $this->handleNext($order);
    }

    private function calculate(Order $order): Order
    {
        return $this->calculator->calculate($order);
    }

}