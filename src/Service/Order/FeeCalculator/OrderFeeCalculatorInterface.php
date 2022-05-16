<?php

namespace App\Service\Order\FeeCalculator;

use App\Service\Order\Invoice\InvoiceInterface;

/**
 * Provides interface for order fee calculator
 * (for example, add some fee, if total price is lower than some threshold value).
 */
interface OrderFeeCalculatorInterface
{
    public function calculateFee(InvoiceInterface $invoice): InvoiceInterface;
}