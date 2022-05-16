<?php

namespace App\Service\Order\Storage;

use App\Service\Order\DTO\Order;

/**
 * Provides interface for order storage (database, api, file, etc.)
 */
interface OrderStorageInterface
{
    public function store(Order $orderInvoice);
}