<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ad>
 *
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function save(Ad $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ad $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAdsCount()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.disabled = :disabled')
            ->setParameter('disabled', false)
            ->getQuery()->useQueryCache(true)
            ->getScalarResult();
    }

    public function findAdsCountBySearch(array $filters)
    {

        $query = $this->createQueryBuilder('ad');
        if($filters["category"]) {
            $query->andWhere('ad.category = :category')
            ->setParameter("category", $filters["category"]);
        }
    }
}
