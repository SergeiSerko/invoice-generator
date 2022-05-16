<?php

namespace App\Service\Order\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class ProductData
{
    private string $productId;
    private string $productName;
    private string $price;
    private string $taxRate;

    public function __construct(string $productId, string $productName, string $price, string $taxRate)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->price = $price;
        $this->taxRate = $taxRate;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): ProductData
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): ProductData
    {
        $this->productName = $productName;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getTaxRate(): string
    {
        return $this->taxRate;
    }

    public function setTaxRate(string $taxRate): ProductData
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): ProductData
    {
        $this->price = $price;
        return $this;
    }

}