<?php

namespace App\Service\Order\DTO;

use App\Service\Order\Invoice\InvoiceInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class Order
{
    const OBJECT_VERSION = '1.0';

    private OrderPlacement $orderPlacement;
    private ?ProductDataCollection $productsData = null;
    private ?InvoiceInterface $invoice = null;
    private string $orderId;
    private bool $handled = false;

    public function __construct(OrderPlacement $orderPlacement)
    {
        $this->orderPlacement = $orderPlacement;
    }

    public function isHandled(): bool
    {
        return $this->handled;
    }

    public function setHandled(bool $handled): Order
    {
        $this->handled = $handled;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getOrderPlacement(): OrderPlacement
    {
        return $this->orderPlacement;
    }

    /**
     * @Groups({"OrderStorage"})
     * @return ProductDataCollection|ProductData[]|null
     */
    public function getProductsData(): ?ProductDataCollection
    {
        return $this->productsData;
    }

    public function setProductsData(ProductDataCollection $productsData): Order
    {
        $this->productsData = $productsData;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getInvoice(): ?InvoiceInterface
    {
        return $this->invoice;
    }

    public function setInvoice(InvoiceInterface $invoice): Order
    {
        $this->invoice = $invoice;
        return $this;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): Order
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getObjectVersion(): string
    {
        return self::OBJECT_VERSION;
    }

}