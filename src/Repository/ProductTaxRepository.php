<?php

namespace App\Repository;

use App\Entity\ProductTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductTax>
 *
 * @method ProductTax|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTax|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTax[]    findAll()
 * @method ProductTax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTax::class);
    }

    public function add(ProductTax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductTax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
