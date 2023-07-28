<?php

namespace App\Controller;

use App\Manager\AnalyticalTechniqueManager;
use App\Manager\CountryManager;
use App\Manager\GasManager;
use App\Manager\ImpactCategoryManager;
use App\Manager\TransportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(
        CountryManager $countryManager,
        ImpactCategoryManager $impactCategoryManager,
        TransportManager $transportManager,
        GasManager $gasManager,
        AnalyticalTechniqueManager $analyticalTechniqueManager
    ): Response {
        $duration = [
            'm' => 'min',
            'h' => 'hour',
        ];

        $datas = [
            'countries' => $countryManager->getAllAsSelectOption() + ['default' => 'FR'],
            'impact_category' => $impactCategoryManager->getAllAsSelectOption(),
            'sample_collection' => [
                'transport_mode' => $transportManager->getAllAsSelectOption(),
                'distance_back_and_forth' => [
                    'default' => 'km',
                    'm' => 'm',
                    'km' => 'km',
                ],
            ],
            'sample_preparation' => [
                'duration' => $duration,
            ],
            'sample_analysis' => [
                'method' => $analyticalTechniqueManager->getAllAsSelectOption(),
                'total_duration_of_the_analysis_unit' => [
                    'm' => 'min',
                    'h' => 'hour',
                ],
                'gas' => $gasManager->getAllAsSelectOption() + ['default' => 'he_bottle'],
            ],
            'data_treatment' => [
                'duration_of_the_data_treatment' => $duration,
                'data_file_size' => [
                    'm' => 'Mb',
                    'g' => 'Gb',
                ],
                'data_storage_type' => [
                    'external_hard_drive' => 'External hard drive',
                    'server' => 'Server',
                    'external_server' => 'External Server',
                    'local_computer' => 'Local computer',
                    'default' => 'local_computer',
                ],
            ],
        ];

        return $this->render('home/index.html.twig', [
            'datas' => $datas,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): RedirectResponse
    {
        $this->container->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        return $this->redirectToRoute('app_home');
    }
}
