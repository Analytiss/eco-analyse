<?php

namespace App\Manager;

use App\Entity\Country;
use App\Entity\ElectricityImpactCategory;
use App\Repository\CountryRepository;
use App\Repository\ElectricityImpactCategoryRepository;

class CountryManager implements ManagerInterface
{
    public function __construct(
        private readonly CountryRepository $repository,
        private readonly ElectricityImpactCategoryRepository $electricityImpactCategoryRepository,
        private readonly ImpactCategoryManager $impactCategoryManager,
    ) {
    }

    public function getAllAsSelectOption(): array
    {
        $countries = [];
        $entities = $this->getAll();
        foreach ($entities as $entity) {
            $countries[$entity->getCode()] = $entity->getName();
        }

        return $countries;
    }

    public function getAll(): array
    {
        return $this->repository->findBy([], ['name' => 'ASC']);
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?ElectricityImpactCategory
    {
        if (!$impact = $this->getCountryElectricityImpactCategory($entityCode, $impactCategoryCode)) {
            if (!$country = $this->getCountryByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new ElectricityImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setCountry($country);
        }
        $impact->setValue($value);

        $this->electricityImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getCountryElectricityImpactCategory(string $countryCode, string $impactCategoryCode): ?ElectricityImpactCategory
    {
        if ($country = $this->getCountryByCode($countryCode)) {
            if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return $this->electricityImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'country' => $country,
                ]);
            }
        }

        return null;
    }

    public function getCountryByCode(string $code): ?Country
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Country
    {
        if (!$country = $this->getCountryByCode($code)) {
            $country = new Country();
            $country->setCode($code);
        }
        $country->setName($label);

        $this->repository->save($country, true);

        return $country;
    }
}
