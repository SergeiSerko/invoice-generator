<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getProductsWithTaxesByCountryCode(array $productIds, string $countryCode): array
    {
        $productIds = array_map(function ($productId) {
            return (new Uuid($productId))->toBinary();
        }, $productIds);
        $query = $this->createQueryBuilder('p')
            ->addSelect('t')
            ->leftJoin('p.productTaxes', 't')
            ->leftJoin('t.country', 'c')
            ->andWhere('p.uuid in (:uuid)')
            ->setParameter('uuid', $productIds)
            ->andWhere('c.code = :countryCode OR c.code IS NULL')
            ->setParameter('countryCode', $countryCode)
            ->getQuery();
        return $query->getResult();
    }
}
