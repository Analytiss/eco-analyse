<?php

namespace App\Repository;

use App\Entity\ElectricityImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ElectricityImpactCategory>
 *
 * @method ElectricityImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectricityImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectricityImpactCategory[]    findAll()
 * @method ElectricityImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectricityImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectricityImpactCategory::class);
    }

    public function save(ElectricityImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ElectricityImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
