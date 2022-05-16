<?php

namespace App\Service\Order\Exception;

/**
 * Exception thrown when an order is not valid
 */
class OrderPlacementValidationException extends \Exception
{
    private $validationError;

    public function __construct($validationError)
    {
        $this->validationError = $validationError;
        parent::__construct('Order placement validation failed');
    }

    public function getValidationError()
    {
        return $this->validationError;
    }
}