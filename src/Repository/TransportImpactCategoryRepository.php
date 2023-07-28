<?php

namespace App\Repository;

use App\Entity\TransportImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TransportImpactCategory>
 *
 * @method TransportImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransportImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransportImpactCategory[]    findAll()
 * @method TransportImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportImpactCategory::class);
    }

    public function save(TransportImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TransportImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
