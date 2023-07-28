<?php

namespace App\Manager;

use App\Entity\Device;
use App\Entity\DeviceImpactCategory;
use App\Repository\DeviceImpactCategoryRepository;
use App\Repository\DeviceRepository;

class DeviceManager implements ManagerInterface
{
    public function __construct(
        private readonly DeviceRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly DeviceImpactCategoryRepository $deviceImpactCategoryRepository,
    ) {
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?DeviceImpactCategory
    {
        if (!$impact = $this->getDeviceImpact($entityCode, $impactCategoryCode)) {
            if (!$device = $this->getDeviceByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new DeviceImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setDevice($device);
        }
        $impact->setValue($value);

        $this->deviceImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getDeviceImpact(string $deviceCode, string $impactCategoryCode): ?DeviceImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($device = $this->getDeviceByCode($deviceCode)) {
                return $this->deviceImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'device' => $device,
                ]);
            }
        }

        return null;
    }

    public function getDeviceByCode(string $code): ?Device
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Device
    {
        if (!$device = $this->getDeviceByCode($code)) {
            $device = new Device();
            $device->setCode($code);
        }
        $device->setName($label);

        $this->repository->save($device, true);

        return $device;
    }
}
