<?php

namespace App\Service\Order\Invoice;

abstract class AbstractInvoiceDecorator implements InvoiceInterface
{
    protected InvoiceInterface $invoice;
    public function __construct(InvoiceInterface $invoice) {
        $this->invoice = $invoice;
    }

    public function getInvoiceEntries(): InvoiceEntryCollection
    {
        return $this->invoice->getInvoiceEntries();
    }

    public function addEntry(InvoiceEntryInterface $entry): void
    {
        $this->invoice->addEntry($entry);
    }

    public function getTotalTaxAmount(): string
    {
       return $this->invoice->getTotalTaxAmount();
    }

    public function getTotalBasePrice(): string
    {
        return $this->invoice->getTotalBasePrice();
    }


}