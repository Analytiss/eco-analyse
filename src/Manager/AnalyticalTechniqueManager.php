<?php

namespace App\Manager;

use App\Entity\AnalyticalTechnique;
use App\Repository\AnalyticalTechniqueRepository;

class AnalyticalTechniqueManager implements ManagerInterface
{
    public function __construct(
        private readonly AnalyticalTechniqueRepository $repository,
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $techniques = [];
        $entities = $this->getAll();
        foreach ($entities as $entity) {
            $techniques[$entity->getCode()] = $entity->getName();
        }

        return $techniques;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value)
    {
        // Implement addImpactCategory() method.
    }

    public function addLabel(string $code, string $label): AnalyticalTechnique
    {
        if (!$technique = $this->getByCode($code)) {
            $technique = new AnalyticalTechnique();
            $technique->setCode($code);
        }
        $technique->setName($label);

        $this->repository->save($technique, true);

        return $technique;
    }

    public function getByCode(string $code): ?AnalyticalTechnique
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }
}
