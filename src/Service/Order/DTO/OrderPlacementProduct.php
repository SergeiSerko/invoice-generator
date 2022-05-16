<?php

namespace App\Service\Order\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class OrderPlacementProduct
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private ?string $productId = null;
    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private ?int $quantity = null;

    /**
     * @Groups({"OrderStorage"})
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }


    public function setProductId(?string $productId): OrderPlacementProduct
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): OrderPlacementProduct
    {
        $this->quantity = $quantity;
        return $this;
    }

}