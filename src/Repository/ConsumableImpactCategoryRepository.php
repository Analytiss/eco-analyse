<?php

namespace App\Repository;

use App\Entity\ConsumableImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsumableImpactCategory>
 *
 * @method ConsumableImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsumableImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsumableImpactCategory[]    findAll()
 * @method ConsumableImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumableImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsumableImpactCategory::class);
    }

    public function save(ConsumableImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConsumableImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
