<?php

namespace App\Service;

use App\Manager\AnalyticalTechniqueManager;
use App\Manager\ConsumableManager;
use App\Manager\CountryManager;
use App\Manager\DeviceManager;
use App\Manager\GasManager;
use App\Manager\ImpactCategoryManager;
use App\Manager\ManagerInterface;
use App\Manager\MediumManager;
use App\Manager\SolventManager;
use App\Manager\TransportManager;

class ImportData
{
    public function __construct(
        private readonly CountryManager $countryManager,
        private readonly GasManager $gasManager,
        private readonly MediumManager $mediumManager,
        private readonly ConsumableManager $consumableManager,
        private readonly DeviceManager $deviceManager,
        private readonly TransportManager $transportManager,
        private readonly SolventManager $solventManager,
        private readonly ImpactCategoryManager $impactCategoryManager,
        private readonly AnalyticalTechniqueManager $analyticalTechniqueManager
    ) {
    }

    public function importEnergy(array $datas): void
    {
        $this->importData($datas, $this->countryManager);
    }

    private function importData(array $datas, ManagerInterface $manager): void
    {
        $headers = null;
        foreach ($datas as $d => $data) {
            if (0 == $d) {
                array_shift($data);
                $headers = $data;
            } else {
                $entityCode = array_shift($data);
                $values = $data;
                foreach ($headers as $h => $header) {
                    $manager->addImpactCategory($entityCode, $header, $values[$h]);
                }
            }
        }
    }

    public function importGas(array $datas): void
    {
        $this->importData($datas, $this->gasManager);
    }

    public function importMedia(array $datas): void
    {
        $this->importData($datas, $this->mediumManager);
    }

    public function importConsumable(array $datas): void
    {
        $this->importData($datas, $this->consumableManager);
    }

    public function importDevice(array $datas): void
    {
        $this->importData($datas, $this->deviceManager);
    }

    public function importTransport(array $datas): void
    {
        $this->importData($datas, $this->transportManager);
    }

    public function importSolvent(array $datas): void
    {
        $this->importData($datas, $this->solventManager);
    }

    public function importCountryLabel(array $datas): void
    {
        $this->importLabel($datas, $this->countryManager);
    }

    private function importLabel(array $datas, ManagerInterface $manager): void
    {
        foreach ($datas as $d => $data) {
            if ($d > 0) {
                $manager->addLabel(code: $data[0], label: $data[1]);
            }
        }
    }

    public function importImpactCategoryLabel(array $datas): void
    {
        foreach ($datas as $d => $data) {
            if ($d > 0) {
                $this->impactCategoryManager->addImpact(
                    code: $data[0],
                    name: $data[1],
                    unit: $data[2],
                    nameFR: $data[3],
                );
            }
        }
    }

    public function importAnalyticalTechniqueLabel(array $datas): void
    {
        $this->importLabel($datas, $this->analyticalTechniqueManager);
    }

    public function importConsumableLabel(array $datas): void
    {
        $this->importLabel($datas, $this->consumableManager);
    }

    public function importGasLabel(array $datas): void
    {
        $this->importLabel($datas, $this->gasManager);
    }

    public function importMediaLabel(array $datas): void
    {
        $this->importLabel($datas, $this->mediumManager);
    }

    public function importTransportLabel(array $datas): void
    {
        $this->importLabel($datas, $this->transportManager);
    }

    public function importSolventLabel(array $datas): void
    {
        $this->importLabel($datas, $this->solventManager);
    }

    public function importDeviceLabel(array $datas): void
    {
        $this->importLabel($datas, $this->deviceManager);
    }
}
