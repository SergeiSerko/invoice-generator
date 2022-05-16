<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\DTO\ProductDataCollection;
use App\Service\Order\Exception\OrderPlacementIntegrityException;
use App\Service\Order\ProductDataProvider\OrderProductDataProviderInterface;

/**
 * Handler used for retrieving products data (name, price, tax.) from DB
 */
class OrderProductDataRetrieverHandler extends AbstractOrderHandler
{
    private OrderProductDataProviderInterface $orderProductDataProvider;

    public function __construct(OrderProductDataProviderInterface $orderProductDataProvider)
    {
        $this->orderProductDataProvider = $orderProductDataProvider;
    }

    public function handle(Order $order): Order
    {
        $productsData = $this->retrieveProductsData($order->getOrderPlacement());
        $order->setProductsData($productsData);
        return $this->handleNext($order);
    }

    /**
     * @throws OrderPlacementIntegrityException
     */
    private function retrieveProductsData(OrderPlacement $orderPlacement): ProductDataCollection
    {
        return $this->orderProductDataProvider->getProductsData($orderPlacement);
    }
}