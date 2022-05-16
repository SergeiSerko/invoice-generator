<?php

namespace App\Service\Order\Invoice;
use Symfony\Component\Serializer\Annotation\Groups;

interface InvoiceInterface
{
    /**
     * @Groups({"OrderStorage", "Invoice"})
     * @return InvoiceEntryCollection|InvoiceEntryInterface[]
     */
    public function getInvoiceEntries(): InvoiceEntryCollection;

    public function addEntry(InvoiceEntryInterface $entry): void;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotal(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotalTaxAmount(): string;

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotalBasePrice(): string;
}