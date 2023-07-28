<?php

namespace App\Manager;

use App\Entity\Solvent;
use App\Entity\SolventImpactCategory;
use App\Repository\SolventImpactCategoryRepository;
use App\Repository\SolventRepository;

class SolventManager implements ManagerInterface
{
    public function __construct(
        private readonly SolventRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly SolventImpactCategoryRepository $solventImpactCategoryRepository
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $solvent = [];
        $entities = $this->getExtra(false);
        foreach ($entities as $entity) {
            $solvent[$entity->getCode()] = $entity->getName();
        }

        return $solvent;
    }

    public function getExtra(bool $extra): array
    {
        return $this->repository->findBy([
            'extra' => $extra,
        ]);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?SolventImpactCategory
    {
        if (!$impact = $this->getSolventImpact($entityCode, $impactCategoryCode)) {
            if (!$solvent = $this->getSolventByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new SolventImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setSolvent($solvent);
        }
        $impact->setValue($value);

        $this->solventImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getSolventImpact(string $solventCode, string $impactCategoryCode): ?SolventImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($solvent = $this->getSolventByCode($solventCode)) {
                return $this->solventImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'solvent' => $solvent,
                ]);
            }
        }

        return null;
    }

    public function getSolventByCode(string $code): ?Solvent
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Solvent
    {
        if (!$solvent = $this->getSolventByCode($code)) {
            $solvent = new Solvent();
            $solvent->setCode($code);
            $solvent->setExtra(false);
        }
        $solvent->setName($label);

        $this->repository->save($solvent, true);

        return $solvent;
    }
}
