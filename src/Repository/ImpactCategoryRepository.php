<?php

namespace App\Repository;

use App\Entity\ImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImpactCategory>
 *
 * @method ImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImpactCategory[]    findAll()
 * @method ImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImpactCategory::class);
    }

    public function save(ImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
