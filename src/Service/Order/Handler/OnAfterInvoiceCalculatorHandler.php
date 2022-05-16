<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\FeeCalculator\OrderFeeCalculatorInterface;

/**
 * Handler used for adding additional calculation logic after basic calculations were made.
 */
class OnAfterInvoiceCalculatorHandler extends AbstractOrderHandler
{
    private OrderFeeCalculatorInterface $feeCalculator;

    public function __construct(OrderFeeCalculatorInterface $feeCalculator)
    {
        $this->feeCalculator = $feeCalculator;
    }

    public function handle(Order $order): Order
    {
        $this->afterCalculate($order);
        return $this->handleNext($order);
    }

    private function afterCalculate(Order $order): Order
    {
        $invoice = $this->feeCalculator->calculateFee($order->getInvoice());
        $order->setInvoice($invoice);
        return $order;
    }
}