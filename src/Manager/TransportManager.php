<?php

namespace App\Manager;

use App\Entity\TransportImpactCategory;
use App\Entity\TransportMode;
use App\Repository\TransportImpactCategoryRepository;
use App\Repository\TransportModeRepository;

class TransportManager implements ManagerInterface
{
    public function __construct(
        private readonly TransportModeRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly TransportImpactCategoryRepository $transportImpactCategoryRepository
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $transports = [];
        $entities = $this->getAll();
        foreach ($entities as $entity) {
            $transports[$entity->getCode()] = $entity->getName();
        }

        return $transports;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?TransportImpactCategory
    {
        if (!$impact = $this->getTransportImpact($entityCode, $impactCategoryCode)) {
            if (!$transportMode = $this->getTransportByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new TransportImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setTransportMode($transportMode);
        }
        $impact->setValue($value);

        $this->transportImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getTransportImpact(string $transportCode, string $impactCategoryCode): ?TransportImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($transportMode = $this->getTransportByCode($transportCode)) {
                return $this->transportImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'transportMode' => $transportMode,
                ]);
            }
        }

        return null;
    }

    public function getTransportByCode(string $code): ?TransportMode
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): TransportMode
    {
        if (!$transportMode = $this->getTransportByCode($code)) {
            $transportMode = new TransportMode();
            $transportMode->setCode($code);
        }

        $transportMode->setName($label);

        $this->repository->save($transportMode, true);

        return $transportMode;
    }
}
