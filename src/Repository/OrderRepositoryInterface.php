<?php

namespace App\Repository;


use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ObjectRepository;

/**
 * @extends ServiceEntityRepository<Order>
 *
 */
interface OrderRepositoryInterface extends ObjectRepository
{
    public function add(Order $entity, bool $flush = false): void;

    public function remove(Order $entity, bool $flush = false): void;

}