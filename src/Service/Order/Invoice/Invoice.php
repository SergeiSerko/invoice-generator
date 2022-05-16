<?php

namespace App\Service\Order\Invoice;

use Symfony\Component\Serializer\Annotation\Groups;

class Invoice implements InvoiceInterface
{
    private InvoiceEntryCollection $invoiceEntries;

    public function __construct()
    {
        $this->invoiceEntries = new InvoiceEntryCollection();
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     * @return InvoiceEntryCollection|InvoiceEntry[]
     */
    public function getInvoiceEntries(): InvoiceEntryCollection
    {
        return $this->invoiceEntries;
    }

    public function addEntry(InvoiceEntryInterface $entry): void
    {
        $this->invoiceEntries->add($entry);
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotal(): string
    {
        $total = '0';
        foreach ($this->getInvoiceEntries() as $entry) {
            $total = bcadd($total, $entry->getTotal(), 2);
        }
        return $total;
    }


    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotalTaxAmount(): string
    {
        $totalTaxAmount = '0';
        foreach ($this->getInvoiceEntries() as $entry) {
            $totalTaxAmount = bcadd($totalTaxAmount, $entry->getTaxAmountTotal(), 2);
        }
        return $totalTaxAmount;
    }


    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getTotalBasePrice(): string
    {
        $totalBasePrice = '0';
        foreach ($this->getInvoiceEntries() as $entry) {
            $totalBasePrice = bcadd($totalBasePrice, $entry->getBasePriceTotal(), 2);
        }
        return $totalBasePrice;
    }

}