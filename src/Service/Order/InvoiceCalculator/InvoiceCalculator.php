<?php

namespace App\Service\Order\InvoiceCalculator;

use App\Service\Order\DTO\Order;
use App\Service\Order\DTO\OrderPlacementProduct;
use App\Service\Order\DTO\ProductData;
use App\Service\Order\Invoice\Invoice;
use App\Service\Order\Invoice\InvoiceEntry;

class InvoiceCalculator implements InvoiceCalculatorInterface
{
    public function calculate(Order $order): Order
    {
        $products = $order->getOrderPlacement()->getProducts();
        $productsData = $order->getProductsData();
        $invoice = $order->getInvoice() ?? new Invoice();
        foreach ($products as $product) {
            $productId = $product->getProductId();
            $productData = $productsData->getByProductId($productId);
            $entry = $this->createInvoiceEntry($product, $productData);
            $invoice->addEntry($entry);
        }
        $order->setInvoice($invoice);
        return $order;
    }

    private function createInvoiceEntry(OrderPlacementProduct $product, ProductData $productData): InvoiceEntry
    {
        $productId = $productData->getProductId();
        $productName = $productData->getProductName();
        $quantity = $product->getQuantity();
        $taxRate = $productData->getTaxRate();
        $basePricePerItem = $productData->getPrice();
        return new InvoiceEntry(
            $productId,
            $productName,
            $quantity,
            $taxRate,
            $basePricePerItem
        );
    }
}