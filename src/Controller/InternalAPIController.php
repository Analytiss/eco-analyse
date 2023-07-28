<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Solvent;
use App\Manager\ConsumableManager;
use App\Manager\ImpactCategoryManager;
use App\Manager\MediumManager;
use App\Manager\SolventManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('ROLE_USER')]
#[Route('/api', name: 'app_internal_api')]
class InternalAPIController extends AbstractController
{
    #[Route('/sample-preparation/solvents', name: '_sample_preparation_solvents', methods: ['GET'])]
    public function samplePreparationSolvents(
        SolventManager $solventManager, SerializerInterface $serializer
    ): JsonResponse {
        $nullable = new Solvent();
        $nullable->setName('Select a solvent');

        $solvents = array_merge([$nullable], $solventManager->getExtra(false));

        return new JsonResponse(json_decode($serializer->serialize($solvents, 'json', [
            AbstractNormalizer::GROUPS => 'entity_info',
        ])), Response::HTTP_OK);
    }

    #[Route('/sample-preparation/mediums', name: '_sample_preparation_mediums', methods: ['GET'])]
    public function samplePreparationMediums(
        MediumManager $mediumManager, SerializerInterface $serializer
    ): JsonResponse {
        $nullable = new Media();
        $nullable->setName('Select a medium');

        $mediums = array_merge([$nullable], $mediumManager->getAll());

        return new JsonResponse(json_decode($serializer->serialize($mediums, 'json', [
            AbstractNormalizer::GROUPS => 'entity_info',
        ])), Response::HTTP_OK);
    }

    #[Route('/sample-preparation/consumables', name: '_sample_preparation_consumables', methods: ['GET'])]
    public function samplePreparationConsumables(
        ConsumableManager $consumableManager, SerializerInterface $serializer
    ): JsonResponse {
        $nullable = new Media();
        $nullable->setName('Select a consumable');

        $consumables = array_merge([$nullable], $consumableManager->getAll());

        return new JsonResponse(json_decode($serializer->serialize($consumables, 'json', [
            AbstractNormalizer::GROUPS => 'entity_info',
        ])), Response::HTTP_OK);
    }

    #[Route('/impact-category', name: '_impact_category', methods: ['POST'])]
    public function impactCategory(
        ImpactCategoryManager $impactCategoryManager, SerializerInterface $serializer, Request $request
    ): JsonResponse {
        $category = $impactCategoryManager->getByCode($request->getPayload()->get('code'));

        return new JsonResponse(json_decode($serializer->serialize($category, 'json', [
            AbstractNormalizer::GROUPS => 'impact_category_info',
        ])), Response::HTTP_OK);
    }
}
