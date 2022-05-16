<?php

namespace App\Service\Order\FeeCalculator;

use App\Service\Order\Invoice\FeeInvoiceDecorator;
use App\Service\Order\Invoice\InvoiceInterface;

/**
 * Implements logic of adding fee to order, if total price is lower than some threshold value. Uses bc math lib
 */
class DecoratorOrderFeeCalculator implements OrderFeeCalculatorInterface
{
    private string $feeThreshold;
    private string $feeAmount;

    public function __construct(string $feeThreshold, string $feeAmount)
    {
        $this->feeThreshold = $feeThreshold;
        $this->feeAmount = $feeAmount;
    }

    public function calculateFee(InvoiceInterface $invoice): InvoiceInterface
    {
        return new FeeInvoiceDecorator($invoice, $this->feeThreshold, $this->feeAmount);
    }
}