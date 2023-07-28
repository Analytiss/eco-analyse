<?php

namespace App\Controller\Admin;

use App\Form\ImportDataType;
use App\Service\ImportData;
use App\Tools\Format;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/import', name: 'app_admin_import')]
#[IsGranted('ROLE_ADMIN')]
class ImportController extends AbstractController
{
    private const FILE_NAME = [
        'electricity.csv', 'gas.csv', 'consumable.csv', 'media.csv', 'device.csv', 'transport.csv', 'solvent.csv',
        'country_label.csv', 'impact_category_label.csv', 'analytical_technique_label.csv', 'consumable_label.csv',
        'gas_label.csv', 'medium_label.csv', 'solvent_label.csv', 'transport_mode_label.csv',
    ];

    /**
     * @throws UnavailableStream|InvalidArgument
     */
    #[Route('/', name: '_index')]
    public function index(Request $request, ImportData $dataImporter): Response
    {
        $form = $this->createForm(ImportDataType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            if ($files = $form->get('file')->getData()) {
                // Vérification des fichiers
                foreach ($files as $file) {
                    if (
                        !in_array($file->getClientOriginalName(), self::FILE_NAME)
                        and !($file instanceof UploadedFile)) {
                        $this->addFlash('error', "File {$file->getClientOriginalName()} not supported");

                        return $this->redirectToRoute('app_admin_import_index');
                    }
                }

                foreach ($files as $f => $file) {
                    $csvReader = Reader::createFromPath($file->getPathname());
                    $csvReader->setDelimiter(';');

                    $csvData = [];
                    foreach ($csvReader as $r => $record) {
                        $csvData[] = $record; // Chaque ligne du fichier CSV sera un tableau dans $csvData
                    }

                    // Traitement des infos
                    if (!str_contains($file->getClientOriginalName(), '_label')) {
                        foreach ($csvData as $d => $data) {
                            if ($d > 0) {
                                foreach ($data as $v => $value) {
                                    if ($v > 0) {
                                        $csvData[$d][$v] = Format::transformScientificToDecimal($value);
                                    }
                                }
                            }
                        }
                    }

                    switch ($file->getClientOriginalName()) {
                        // Label
                        case 'analytical_technique_label.csv':
                            $dataImporter->importAnalyticalTechniqueLabel($csvData);
                            break;
                        case 'consumable_label.csv':
                            $dataImporter->importConsumableLabel($csvData);
                            break;
                        case 'country_label.csv':
                            $dataImporter->importCountryLabel($csvData);
                            break;
                        case 'device_label.csv':
                            $dataImporter->importDeviceLabel($csvData);
                            break;
                        case 'gas_label.csv':
                            $dataImporter->importGasLabel($csvData);
                            break;
                        case 'impact_category_label.csv':
                            $dataImporter->importImpactCategoryLabel($csvData);
                            break;
                        case 'medium_label.csv':
                            $dataImporter->importMediaLabel($csvData);
                            break;
                        case 'solvent_label.csv':
                            $dataImporter->importSolventLabel($csvData);
                            break;
                        case 'transport_mode_label.csv':
                            $dataImporter->importTransportLabel($csvData);
                            break;

                            // Valeurs
                        case 'consumable.csv':
                            $dataImporter->importConsumable($csvData);
                            break;
                        case 'device.csv':
                            $dataImporter->importDevice($csvData);
                            break;
                        case 'electricity.csv':
                            $dataImporter->importEnergy($csvData);
                            break;
                        case 'gas.csv':
                            $dataImporter->importGas($csvData);
                            break;
                        case 'media.csv':
                            $dataImporter->importMedia($csvData);
                            break;
                        case 'solvent.csv':
                            $dataImporter->importSolvent($csvData);
                            break;
                        case 'transport.csv':
                            $dataImporter->importTransport($csvData);
                            break;
                    }
                }

                $this->addFlash('success', 'Datas updated');

                return $this->redirectToRoute('app_admin_import_index');
            } else {
                $form->get('file')->addError(new FormError('Please upload a valid CSV file'));
                $this->addFlash('error', 'Please upload a valid CSV file');
            }
        }

        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
