<?php

namespace App\Controller\REST;

use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractFOSRestController
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("", name="getProducts", methods={"GET"})
     * @Rest\View(serializerGroups={"Product"})
     */
    public function getProducts(): array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @Route("/example", name="getOrderPlacementExampleData", methods={"GET"})
     * @Rest\View()
     */
    public function getOrderPlacementExampleData(): array
    {
        $products = $this->productRepository->findAll();
        $c  = 1;
        $data = [
            'countryCode' => 'FI',
            'email' => 'example@example.com',
            'sendInvoiceViaEmail' => true,
            'invoiceFormat' => 'json',
            'products' => array_map(function (Product $p) use (&$c) {
                return [
                    'productId' => $p->getUuid()->toRfc4122(),
                    'quantity' => $c++
                ];
            }, $products),
        ];
        return $data;
    }
}