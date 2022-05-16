<?php

namespace App\Service\Order\ProductDataProvider;

use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\DTO\ProductData;
use App\Service\Order\DTO\ProductDataCollection;
use App\Service\Order\Exception\OrderPlacementIntegrityException;

/**
 * Retrieves product data (price, tax, name) for an order from DB.
 */
class OrderProductDataProvider implements OrderProductDataProviderInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsData(OrderPlacement $orderPlacement): ProductDataCollection
    {
        $orderPlacementProductIds = [];
        foreach ($orderPlacement->getProducts() as $product) {
            $orderPlacementProductIds[] = $product->getProductId();
        }

        $productsWithTaxes = $this->getProductsWithTaxesFromDB(
            $orderPlacementProductIds,
            $orderPlacement->getCountryCode()
        );

        if (count($orderPlacementProductIds) !== count($productsWithTaxes)) {
            $productsWithTaxesIds = array_map(function (Product $product) {
                return $product->getUuid();
            }, $productsWithTaxes);
            $missingProducts = array_diff($orderPlacementProductIds, $productsWithTaxesIds);
            throw new OrderPlacementIntegrityException($missingProducts);
        }
        return $this->fillProductDataCollection($productsWithTaxes);
    }

    private function getProductsWithTaxesFromDB(array $productIds, string $countryCode): array
    {
        return $this->productRepository->getProductsWithTaxesByCountryCode($productIds, $countryCode);
    }

    /**
     * @param Product[] $productsWithTaxes
     */
    private function fillProductDataCollection(array $productsWithTaxes): ProductDataCollection
    {
        $result = new ProductDataCollection();
        foreach ($productsWithTaxes as $product) {
            $tax = $product->getProductTaxes()->current();
            $result->add(
                new ProductData(
                    $product->getUuid(),
                    $product->getName(),
                    $product->getPrice(),
                    $tax ? $tax->getTaxRate() : '0'
                )
            );
        }
        return $result;
    }
}