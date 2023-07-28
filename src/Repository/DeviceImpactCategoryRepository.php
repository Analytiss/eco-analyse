<?php

namespace App\Repository;

use App\Entity\DeviceImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeviceImpactCategory>
 *
 * @method DeviceImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceImpactCategory[]    findAll()
 * @method DeviceImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceImpactCategory::class);
    }

    public function save(DeviceImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DeviceImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
