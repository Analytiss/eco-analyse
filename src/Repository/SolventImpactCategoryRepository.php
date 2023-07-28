<?php

namespace App\Repository;

use App\Entity\SolventImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SolventImpactCategory>
 *
 * @method SolventImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolventImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolventImpactCategory[]    findAll()
 * @method SolventImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolventImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolventImpactCategory::class);
    }

    public function save(SolventImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SolventImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
