<?php

namespace App\Service\Order\OrderPlacementValidator;

use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\Exception\OrderPlacementValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Implements user input validation via Symfony Validator component
 */
class OrderPlacementValidator implements OrderPlacementValidatorInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateInput(OrderPlacement $orderPlacement)
    {
        $validationGroups = ['Default'];
        if ($orderPlacement->isSendInvoiceViaEmail()) {
            $validationGroups[] = 'SendInvoiceViaEmail';
        }
        $violations = $this->validator->validate($orderPlacement, null, $validationGroups);
        if (count($violations) > 0) {
            throw new OrderPlacementValidationException($violations);
        }
    }


}