<?php

namespace App\Entity;

use App\Repository\ProductTaxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductTaxRepository::class)
 */
class ProductTax
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productTaxes")
     * @ORM\JoinColumn(nullable=false)
     * @var Product
     */
    private Product $product;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="countryTaxes")
     * @ORM\JoinColumn(nullable=false)
     * @var Country
     */
    private Country $country;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     * @var string
     */
    private string $taxRate;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @Groups({"Product"})
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @Groups({"Product"})
     */
    public function getTaxRate(): ?string
    {
        return $this->taxRate;
    }

    public function setTaxRate(string $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }
}
