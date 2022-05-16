<?php

namespace App\Service\Order\Invoice;
use Symfony\Component\Serializer\Annotation\Groups;

class FeeInvoiceDecorator extends AbstractInvoiceDecorator
{
    private string $feeThreshold;
    private string $feeAmount;
    public function __construct(InvoiceInterface $invoice, string $feeThreshold, string $feeAmount)
    {
        $this->feeThreshold = $feeThreshold;
        $this->feeAmount = $feeAmount;
        parent::__construct($invoice);
    }

    public function getTotal(): string
    {
        $total = $this->invoice->getTotal();
        if($this->isTotalLessThanThreshold($total)) {
            $total = bcadd($total, $this->feeAmount, 2);
        }
        return $total;
    }

    private function isTotalLessThanThreshold(string $total):bool
    {
        return bccomp($this->feeThreshold, $total, 2) === 1;
    }

    /**
     * @Groups({"OrderStorage", "Invoice"})
     */
    public function getFee():string
    {
        $total = $this->invoice->getTotal();
        if($this->isTotalLessThanThreshold($total)) {
            return $this->feeAmount;
        }
        return '0';
    }
}