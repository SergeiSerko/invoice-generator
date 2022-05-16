<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    use EntityIdTrait;


    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=ProductTax::class, mappedBy="product", orphanRemoval=true)
     * @var Collection<int, ProductTax>
     */
    private $productTaxes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @var string
     */
    private string $price;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->productTaxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"Product"})
     */
    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    /**
     * @Groups({"Product"})
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductTax>
     * @Groups({"Product"})
     */
    public function getProductTaxes(): Collection
    {
        return $this->productTaxes;
    }

    public function addProductTax(ProductTax $productTax): self
    {
        if (!$this->productTaxes->contains($productTax)) {
            $this->productTaxes[] = $productTax;
            $productTax->setProduct($this);
        }

        return $this;
    }

    public function removeProductTax(ProductTax $productTax): self
    {
        if ($this->productTaxes->removeElement($productTax)) {
            // set the owning side to null (unless already changed)
            if ($productTax->getProduct() === $this) {
                $productTax->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"Product"})
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
