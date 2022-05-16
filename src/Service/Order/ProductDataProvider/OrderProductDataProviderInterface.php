<?php

namespace App\Service\Order\ProductDataProvider;

use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\DTO\ProductDataCollection;
use App\Service\Order\Exception\OrderPlacementIntegrityException;

/**
 * Interface for retrieving product data (price, tax, name) for an order.
 */
interface OrderProductDataProviderInterface
{
    /**
     * @throws OrderPlacementIntegrityException
     */
    public function getProductsData(OrderPlacement $orderPlacement): ProductDataCollection;
}