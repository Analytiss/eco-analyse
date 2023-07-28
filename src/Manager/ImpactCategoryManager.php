<?php

namespace App\Manager;

use App\Entity\ImpactCategory;
use App\Repository\ImpactCategoryRepository;

class ImpactCategoryManager implements ManagerInterface
{
    public function __construct(
        private readonly ImpactCategoryRepository $repository
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $categories = [];
        $entities = $this->getAll();
        foreach ($entities as $entity) {
            $categories[$entity->getCode()] = $entity->getName();
        }

        return $categories;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value)
    {
    }

    public function addLabel(string $code, string $label)
    {
    }

    public function addImpact(string $code, string $name, ?string $unit, ?string $nameFR): ImpactCategory
    {
        if (!$category = $this->getByCode($code)) {
            $category = new ImpactCategory();
            $category->setCode($code);
        }
        $category->setName($name);
        $category->setUnit($unit);
        $category->setNameFR($nameFR);

        $this->repository->save($category, true);

        return $category;
    }

    public function getByCode(string $code): ?ImpactCategory
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }
}
