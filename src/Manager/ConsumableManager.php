<?php

namespace App\Manager;

use App\Entity\Consumable;
use App\Entity\ConsumableImpactCategory;
use App\Repository\ConsumableImpactCategoryRepository;
use App\Repository\ConsumableRepository;

class ConsumableManager implements ManagerInterface
{
    public function __construct(
        private readonly ConsumableRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly ConsumableImpactCategoryRepository $consumableImpactCategoryRepository,
    ) {
    }

    public function getAll(): array
    {
        return $this->repository->findBy([], ['name' => 'ASC']);
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?ConsumableImpactCategory
    {
        if (!$impact = $this->getConsumableImpact($entityCode, $impactCategoryCode)) {
            if (!$consumable = $this->getConsumableByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new ConsumableImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setConsumable($consumable);
        }
        $impact->setValue($value);

        $this->consumableImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getConsumableImpact(string $consumableCode, string $impactCategoryCode): ?ConsumableImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($consumable = $this->getConsumableByCode($consumableCode)) {
                return $this->consumableImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'consumable' => $consumable,
                ]);
            }
        }

        return null;
    }

    public function getConsumableByCode(string $code): ?Consumable
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Consumable
    {
        if (!$consumable = $this->getConsumableByCode($code)) {
            $consumable = new Consumable();
            $consumable->setCode($code);
        }
        $consumable->setName($label);

        $this->repository->save($consumable, true);

        return $consumable;
    }
}
