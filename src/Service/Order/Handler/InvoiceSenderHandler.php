<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\Sender\OrderInvoiceSenderInterface;

/**
 * Handler used for sending invoice to client.
 */
class InvoiceSenderHandler extends AbstractOrderHandler
{
    private OrderInvoiceSenderInterface $invoiceSender;

    public function __construct(OrderInvoiceSenderInterface $invoiceSender)
    {
        $this->invoiceSender = $invoiceSender;
    }

    public function handle(Order $order): Order
    {
        if ($order->getOrderPlacement()->isSendInvoiceViaEmail()) {
            $this->invoiceSender->send($order);
        }
        // Send invoice to customer
        return $this->handleNext($order);
    }
}