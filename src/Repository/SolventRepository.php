<?php

namespace App\Repository;

use App\Entity\Solvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Solvent>
 *
 * @method Solvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solvent[]    findAll()
 * @method Solvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solvent::class);
    }

    public function save(Solvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Solvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
