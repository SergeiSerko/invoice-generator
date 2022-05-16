<?php

namespace App\Service\Order\Handler;

use App\Service\Order\DTO\Order;
use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\Exception\OrderPlacementValidationException;
use App\Service\Order\OrderPlacementValidator\OrderPlacementValidatorInterface;

/**
 * Handler used for input validation
 */
class OrderPlacementValidatorHandler extends AbstractOrderHandler
{
    private OrderPlacementValidatorInterface $validator;

    public function __construct(OrderPlacementValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Order $order): Order
    {
        $this->validateOrderPlacement($order->getOrderPlacement());

        return $this->handleNext($order);
    }

    /**
     * @throws OrderPlacementValidationException
     */
    private function validateOrderPlacement(OrderPlacement $orderPlacement): void
    {
        $this->validator->validateInput($orderPlacement);
    }
}