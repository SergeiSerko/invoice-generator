<?php

namespace App\Service\Order\Exception;

/**
 * Exception thrown when an order products are not resolved.
 */
class OrderPlacementIntegrityException extends \Exception
{
    private array $missingProducts;

    public function __construct(array $missingProducts)
    {
        $this->missingProducts = $missingProducts;
        parent::__construct('Order placement integrity violation');
    }

    public function getMissingProducts(): array
    {
        return $this->missingProducts;
    }
}