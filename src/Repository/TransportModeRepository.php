<?php

namespace App\Repository;

use App\Entity\TransportMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TransportMode>
 *
 * @method TransportMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransportMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransportMode[]    findAll()
 * @method TransportMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportMode::class);
    }

    public function save(TransportMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TransportMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
