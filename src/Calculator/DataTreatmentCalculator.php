<?php

namespace App\Calculator;

use App\Manager\CountryManager;
use App\Manager\DeviceManager;

class DataTreatmentCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    private ?string $duration;

    public function __construct(
        private readonly DeviceManager $deviceManager,
        private readonly CountryManager $countryManager
    ) {
    }

    public function initData(array $data): void
    {
        $this->activated = 'true' == $data['activated'];
        $this->duration = match ($data['unit']) {
            'm' => (float) $data['value'] / 60,
            default => (float) $data['value'], // Default : h
        };
        $this->impactCategory = $data['impactCategory'] ?? 'gpw'; // Default : Global warming
        $this->country = $data['country'] ?? 'FR'; // Default : France
    }

    public function calculation(): ?array
    {
        $deviceContribution = 0;
        $impact = 0;
        if (!$this->activated) {
            return ['error' => 'not activated'];
        }

        foreach (self::DEVICES as $device) {
            if (!$deviceImpact = $this->deviceManager->getDeviceImpact($device, $this->impactCategory)) {
                return ['error' => $device];
            }

            $impact += $this->duration * $deviceImpact->getValue();
            $deviceContribution = $this->duration * $deviceImpact->getValue();
        }

        $energy = $this->duration * self::ENERGY_CONSUMPTION;

        // Energy impact
        $countryImpactCategory = $this->countryManager->getCountryElectricityImpactCategory(
            $this->country, $this->impactCategory
        );

        if (!$countryImpactCategory) {
            return ['error' => 'no countryImpactCategory'];
        }

        $impact += $countryImpactCategory->getValue() * $energy;

        return [
            'duration' => $this->duration * 60, // Retour en minute
            'impact' => $impact,
            'energy' => $energy,
            'energyContribution' => $energy,
            'deviceContribution' => $deviceContribution,
        ];
    }
}
