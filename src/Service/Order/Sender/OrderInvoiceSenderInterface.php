<?php

namespace App\Service\Order\Sender;

use App\Service\Order\DTO\Order;

/**
 * Provides interface for order sending (email, sms, api, etc.).
 * TODO: add some kind of transport resolver
 */
interface OrderInvoiceSenderInterface
{
    public function send(Order $order): void;

}