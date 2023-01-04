<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<City>
 *
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function save(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSearchByCity(Request $request)
    {
        $query =  $this->createQueryBuilder('c');
        if($request->query->get('name')) {
            return $query->where('c.name LIKE :name')
                ->setParameter('name', '%'. $request->query->get('name') .'%')
                ->getQuery()->setMaxResults(10)->getResult();
        } elseif ($request->query->get('code_postale')) {
            return $query->where('c.codePostal LIKE :codePostale')
                ->setParameter('codePostale', '%'. $request->query->get('code_postale') .'%')
                ->getQuery()->setMaxResults(10)->getResult();
        } else {
            return null;
        }
    }
}
