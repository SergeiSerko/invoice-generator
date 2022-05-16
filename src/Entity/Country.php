<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=ProductTax::class, mappedBy="country", orphanRemoval=true)
     * @return Collection<int, ProductTax>
     */
    private $countryTaxes;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private string $code;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->countryTaxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"Country"})
     */
    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    /**
     * @Groups({"Country"})
     */
    public function getName(): ?string
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
     */
    public function getCountryTaxes(): Collection
    {
        return $this->countryTaxes;
    }

    public function addCountryTaxes(ProductTax $productTax): self
    {
        if (!$this->countryTaxes->contains($productTax)) {
            $this->countryTaxes[] = $productTax;
            $productTax->setCountry($this);
        }

        return $this;
    }

    public function removeCountryTaxes(ProductTax $productTax): self
    {
        if ($this->countryTaxes->removeElement($productTax)) {
            // set the owning side to null (unless already changed)
            if ($productTax->getCountry() === $this) {
                $productTax->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"Product","Country"})
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
