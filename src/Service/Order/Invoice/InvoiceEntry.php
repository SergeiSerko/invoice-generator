<?php

namespace App\Service\Order\Invoice;

use Symfony\Component\Serializer\Annotation\Groups;

class InvoiceEntry implements InvoiceEntryInterface
{
    private string $productId;
    private string $productName;
    private int $quantity;
    private string $taxRate;
    private string $basePricePerItem;
    private string $taxAmountPerItem;
    private string $basePriceTotal;
    private string $taxAmountTotal;
    private string $total;

    public function __construct(
        string $productId,
        string $productName,
        int $quantity,
        string $taxRate,
        string $basePricePerItem

    ) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->taxRate = $taxRate;
        $this->basePricePerItem = $basePricePerItem;
        $this->taxAmountPerItem = bcmul($this->basePricePerItem, bcdiv($this->taxRate, 100, 4), 2);
        $this->basePriceTotal = bcmul($this->basePricePerItem, $quantity, 2);
        $this->taxAmountTotal = bcmul($this->basePriceTotal, bcdiv($taxRate, 100, 4), 2);
        $this->total = bcadd($this->basePriceTotal, $this->taxAmountTotal, 2);
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }


    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxRate(): string
    {
        return $this->taxRate;
    }


    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getBasePricePerItem(): string
    {
        return $this->basePricePerItem;
    }


    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxAmountPerItem(): string
    {
        return $this->taxAmountPerItem;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getBasePriceTotal(): string
    {
        return $this->basePriceTotal;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxAmountTotal(): string
    {
        return $this->taxAmountTotal;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotal(): string
    {
        return $this->total;
    }

}