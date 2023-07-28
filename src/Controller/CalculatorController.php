<?php

namespace App\Controller;

use App\Calculator\DataTreatmentCalculator;
use App\Calculator\SampleAnalysisCalculator;
use App\Calculator\SampleCollectionCalculator;
use App\Calculator\SamplePreparationCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/calculator', name: 'app_calculator')]
#[IsGranted('ROLE_USER')]
class CalculatorController extends AbstractController
{
    #[Route('/sample/collection', name: '_sample_collection', methods: ['POST'])]
    public function sampleCollection(Request $request, SampleCollectionCalculator $calculator): JsonResponse
    {
        $calculator->initData($request->getPayload()->all());

        return new JsonResponse($calculator->calculation(), Response::HTTP_OK);
    }

    #[Route('/sample/preparation', name: '_sample_preparation', methods: ['POST'])]
    public function samplePreparation(Request $request, SamplePreparationCalculator $calculator): JsonResponse
    {
        $calculator->initData($request->getPayload()->all());

        return new JsonResponse($calculator->calculation(), Response::HTTP_OK);
    }

    #[Route('/sample/analysis', name: '_sample_analysis', methods: ['POST'])]
    public function sampleAnalysis(Request $request, SampleAnalysisCalculator $calculator): JsonResponse
    {
        $calculator->initData($request->getPayload()->all());

        return new JsonResponse($calculator->calculation(), Response::HTTP_OK);
    }

    #[Route('/data/treatment', name: '_data_treatment', methods: ['POST'])]
    public function dataTreatment(Request $request, DataTreatmentCalculator $calculator): JsonResponse
    {
        $calculator->initData($request->getPayload()->all());

        return new JsonResponse($calculator->calculation(), Response::HTTP_OK);
    }
}
