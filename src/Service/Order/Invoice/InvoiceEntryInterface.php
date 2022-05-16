<?php

namespace App\Service\Order\Invoice;
use Symfony\Component\Serializer\Annotation\Groups;

interface InvoiceEntryInterface
{
    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getProductId(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getProductName(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getQuantity(): int;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxRate(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getBasePricePerItem(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxAmountPerItem(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getBasePriceTotal(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTaxAmountTotal(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotal(): string;
}