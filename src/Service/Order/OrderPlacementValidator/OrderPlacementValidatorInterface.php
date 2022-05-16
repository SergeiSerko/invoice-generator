<?php

namespace App\Service\Order\OrderPlacementValidator;

use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\Exception\OrderPlacementValidationException;

/**
 * Provides interface for validating user input
 */
interface OrderPlacementValidatorInterface
{
    /**
     * @throws OrderPlacementValidationException
     */
    public function validateInput(OrderPlacement $orderPlacement);
}