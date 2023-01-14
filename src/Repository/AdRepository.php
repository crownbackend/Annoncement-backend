<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findAdsCountBySearch(array $filters, $rangeMin = 0, $rangeMax = 50)
    {
        if(filter_var($filters['searchAds'], FILTER_VALIDATE_BOOLEAN)) {
            $query = $this->createQueryBuilder('ad')
                ->where("ad.disabled = :disabled")->setParameter("disabled", false);
        } else {
            $query = $this->createQueryBuilder('ad')
                ->select('count(ad.id)')
                ->where("ad.disabled = :disabled")->setParameter("disabled", false);
        }
        $query->orderBy('ad.createdAt', 'DESC');
        if($filters["category"]) {
            $query->andWhere('ad.category = :category')
            ->setParameter("category", $filters["category"]);
        }
        if($filters["city"]) {
            $query->andWhere('ad.city = :city')
                ->setParameter("city", $filters["city"]);
        }
        if($filters["search"]) {
            $query->andWhere('ad.name LIKE :search')
                ->andWhere('ad.description LIKE :search')
                ->setParameter('search', '%'. $filters["search"] .'%')
            ;
        }
        if($filters["priceMin"] && $filters["priceMax"]) {
            $query->andWhere('ad.price BETWEEN :min AND :max')
                ->setParameter("min", $filters["priceMin"])
                ->setParameter("max", $filters["priceMax"]);
        } else if($filters['priceMax']) {
            $query->andWhere("ad.price <= :price")
                ->setParameter("price", $filters["priceMax"]);
        } else if($filters["priceMin"]) {
            $query->andWhere("ad.price >= :price")
                ->setParameter("price", $filters["priceMin"]);
        }
        if(filter_var($filters['searchAds'], FILTER_VALIDATE_BOOLEAN)) {
            $numberMaxPerPage = $rangeMax - $rangeMin;
            $query->setFirstResult($rangeMin)->setMaxResults($numberMaxPerPage);
            return new Paginator($query);
        } else {
            return $query->getQuery()->getScalarResult();
        }
    }

    public function findByUserAdsLastResult(User $user)
    {
        return $this->createQueryBuilder('a')
            ->where("a.disabled = :disabled")->setParameter("disabled", false)
            ->andWhere('a.user = :user')->setParameter('user', $user)
            ->getQuery()->setMaxResults(4)->getResult();
    }
}
