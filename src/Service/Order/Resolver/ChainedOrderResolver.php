<?php

namespace App\Service\Order\Resolver;

use App\Service\Order\DTO\Order;
use App\Service\Order\Exception\OrderNotResolvedException;
use App\Service\Order\Handler\OrderHandlerInterface;

/**
 * "Runner" of chain-of-responsibility.
 */
class ChainedOrderResolver implements OrderResolverInterface
{
    private OrderHandlerInterface $invoiceHandler;

    public function __construct(OrderHandlerInterface $invoiceHandler)
    {
        $this->invoiceHandler = $invoiceHandler;
    }

    /**
     * @throws OrderNotResolvedException
     */
    public function resolve(Order $invoice): Order
    {
        $this->invoiceHandler->handle($invoice);
        if (!$invoice->isHandled()) {
            throw new OrderNotResolvedException('Order is not resolved');
        }
        return $invoice;
    }
}