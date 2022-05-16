<?php

namespace App\Service\Order\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

function get_product_from_order_entry(OrderPlacementProduct $entry): ?string
{
    return $entry->getProductId();
}

class OrderPlacement
{
    /**
     * @Assert\NotBlank()
     * @Assert\Unique(normalizer="App\Service\Order\DTO\get_product_from_order_entry")
     */
    private OrderPlacementProductCollection $products;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(2)
     */
    private ?string $countryCode = null;
    /**
     * @Assert\NotBlank()
     * @Assert\Choice(choices=App\Service\Order\Types\InvoiceFormatEnumType::VALUES)
     */
    private ?string $invoiceFormat = null;
    /**
     * @Assert\Type("bool")
     */
    private ?bool $sendInvoiceViaEmail = null;
    /**
     * @Assert\NotBlank(groups={"SendInvoiceViaEmail"})
     * @Assert\Email(groups={"SendInvoiceViaEmail"})
     */
    private ?string $email = null;


    public function __construct()
    {
        $this->products = new OrderPlacementProductCollection();
    }

    /**
     * @Groups({"OrderStorage"})
     * @return OrderPlacementProductCollection|OrderPlacementProduct[]
     */
    public function getProducts(): OrderPlacementProductCollection
    {
        return $this->products;
    }

    public function addProduct(OrderPlacementProduct $product): void
    {
        $this->products->add($product);
    }

    public function removeProduct(OrderPlacementProduct $product): void
    {
        $this->products->remove($product);
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): OrderPlacement
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getInvoiceFormat(): ?string
    {
        return $this->invoiceFormat;
    }

    public function setInvoiceFormat(?string $invoiceFormat): OrderPlacement
    {
        $this->invoiceFormat = $invoiceFormat;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function isSendInvoiceViaEmail(): ?bool
    {
        return $this->sendInvoiceViaEmail;
    }

    public function setSendInvoiceViaEmail(?bool $sendInvoiceViaEmail): OrderPlacement
    {
        $this->sendInvoiceViaEmail = $sendInvoiceViaEmail;
        return $this;
    }

    /**
     * @Groups({"OrderStorage"})
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): OrderPlacement
    {
        $this->email = $email;
        return $this;
    }
}