<?php

namespace App\Manager;

use App\Entity\Media;
use App\Entity\MediaImpactCategory;
use App\Repository\MediaImpactCategoryRepository;
use App\Repository\MediaRepository;

class MediumManager implements ManagerInterface
{
    public function __construct(
        private readonly MediaRepository $repository,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly MediaImpactCategoryRepository $mediaImpactCategoryRepository
    ) {
    }

    public function getAll(): array
    {
        return $this->repository->findBy([], ['name' => 'ASC']);
    }

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value): ?MediaImpactCategory
    {
        if (!$impact = $this->getMediumImpact($entityCode, $impactCategoryCode)) {
            if (!$media = $this->getMediumByCode($entityCode) or !$impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
                return null;
            }
            $impact = new MediaImpactCategory();
            $impact->setImpactCategory($impactCategory);
            $impact->setMedia($media);
        }
        $impact->setValue($value);

        $this->mediaImpactCategoryRepository->save($impact, true);

        return $impact;
    }

    public function getMediumImpact(string $mediumCode, string $impactCategoryCode): ?MediaImpactCategory
    {
        if ($impactCategory = $this->impactCategoryManager->getByCode($impactCategoryCode)) {
            if ($medium = $this->getMediumByCode($mediumCode)) {
                return $this->mediaImpactCategoryRepository->findOneBy([
                    'impactCategory' => $impactCategory,
                    'media' => $medium,
                ]);
            }
        }

        return null;
    }

    public function getMediumByCode(string $code): ?Media
    {
        return $this->repository->findOneBy([
            'code' => $code,
        ]);
    }

    public function addLabel(string $code, string $label): Media
    {
        if (!$media = $this->getMediumByCode($code)) {
            $media = new Media();
            $media->setCode($code);
        }
        $media->setName($label);

        $this->repository->save($media, true);

        return $media;
    }
}
