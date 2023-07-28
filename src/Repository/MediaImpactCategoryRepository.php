<?php

namespace App\Repository;

use App\Entity\MediaImpactCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaImpactCategory>
 *
 * @method MediaImpactCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaImpactCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaImpactCategory[]    findAll()
 * @method MediaImpactCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaImpactCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaImpactCategory::class);
    }

    public function save(MediaImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MediaImpactCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
