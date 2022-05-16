<?php

namespace App\Service\Order\InvoiceCalculator;

use App\Service\Order\DTO\Order;

/**
 * Provides interface for some invoice calculator
 */
interface InvoiceCalculatorInterface
{
    public function calculate(Order $order): Order;
}