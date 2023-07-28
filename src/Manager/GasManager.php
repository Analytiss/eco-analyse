<?php

namespace App\Manager;

use App\Entity\Gas;
use App\Entity\GasImpactCategory;
use App\Repository\GasImpactCategoryRepository;
use App\Repository\GasRepository;

class GasManager implements ManagerInterface
{
    public function __construct(
        private readonly GasRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly GasImpactCategoryRepository $gasImpactCategoryRepository
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $gases = [];
        $entities = $this->getAll();
        foreach ($entities as $entity) {
            $gases[$entity->getCode()] = $entity->getName();
        }

        return $gases;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?GasImpactCategory
    {
        if (!$impact = $this->getGasImpact($entityCode, $impactCategoryCode)) {
            if (!$gas = $this->getGasByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new GasImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setGas($gas);
        }
        $impact->setValue($value);

        $this->gasImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getGasImpact(string $gasCode, string $impactCategoryCode): ?GasImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($gas = $this->getGasByCode($gasCode)) {
                return $this->gasImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'gas' => $gas,
                ]);
            }
        }

        return null;
    }

    public function getGasByCode(string $code): ?Gas
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Gas
    {
        if (!$gas = $this->getGasByCode($code)) {
            $gas = new Gas();
            $gas->setCode($code);
        }
        $gas->setName($label);

        $this->repository->save($gas, true);

        return $gas;
    }
}
