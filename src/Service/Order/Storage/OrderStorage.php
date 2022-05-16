<?php

namespace App\Service\Order\Storage;

use App\Repository\OrderRepositoryInterface;
use App\Service\Order\DTO\Order;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Implementation of OrderStorageInterface, which stores orders as json encoded objects in database using Order entry.
 */
class OrderStorage implements OrderStorageInterface
{
    private OrderRepositoryInterface $orderRepository;
    private ObjectNormalizer $normalizer;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ObjectNormalizer $normalizer
    ) {
        $this->orderRepository = $orderRepository;
        $this->normalizer = $normalizer;
    }

    public function store(Order $orderInvoice)
    {
        $order = $this->createEntity($orderInvoice);
        $this->storeInDB($order);
        $orderInvoice->setOrderId($order->getUuid()->toRfc4122());
    }

    /**
     * @throws ExceptionInterface
     */
    private function createEntity(Order $order): \App\Entity\Order
    {
        $entity = new \App\Entity\Order();
        $orderData = $this->normalizer->normalize($order, 'json', ['groups' => ['OrderStorage']]);
        $entity->setData($orderData);
        return $entity;
    }

    private function storeInDB(\App\Entity\Order $order)
    {
        $this->orderRepository->add($order, true);
    }

}