<?php

namespace App\Repository;


use App\Entity\Product;
use Doctrine\Persistence\ObjectRepository;

interface ProductRepositoryInterface extends ObjectRepository
{
    public function add(Product $entity, bool $flush = false): void;

    public function remove(Product $entity, bool $flush = false): void;

    /**
     * @return Product[]
     */
    public function getProductsWithTaxesByCountryCode(array $productIds, string $countryCode): array;

}