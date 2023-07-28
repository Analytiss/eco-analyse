<?php

namespace App\Calculator;

use App\Manager\ConsumableManager;
use App\Manager\CountryManager;
use App\Manager\MediumManager;
use App\Manager\SolventManager;

class SamplePreparationCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    private ?float $duration;
    private ?array $solvents;
    private ?array $mediums;
    private ?array $consumables;

    public function __construct(
        private readonly SolventManager $solventManager,
        private readonly MediumManager $mediumManager,
        private readonly ConsumableManager $consumableManager,
        private readonly CountryManager $countryManager,
    ) {
    }

    public function initData(array $data): void
    {
        $this->solvents = json_decode($data['solvents'] ?? []);
        $this->mediums = json_decode($data['mediums'] ?? []);
        $this->consumables = json_decode($data['consumables'] ?? []);
        $this->activated = 'true' == $data['activated'];
        $this->impactCategory = $data['impactCategory'] ?? 'gpw'; // Default : Global warming
        $this->country = $data['country'] ?? 'FR'; // Default : France

        $this->duration = match ($data['durationUnit']) {
            'm' => (float) $data['durationValue'] / 60,
            default => (float) $data['durationValue'], // Default : m
        };
    }

    public function calculation(): ?array
    {
        $solventContribution = 0;
        $consumableContribution = 0;
        $duration = $this->duration * 60;
        $impact = 0;
        $energy = 0; // Energy toujours présente
        if (!$this->activated) {
            return ['error' => 'not activated'];
        }

        // Solvents Déchets
        $solvents = $this->solventManager->getExtra(true);
        $solventWasteImpact = 0;
        foreach ($solvents as $solvent) {
            $solventImpact = $this->solventManager->getSolventImpact($solvent->getCode(), $this->impactCategory);
            if (!$solventImpact) {
                return ['error' => $solvent->getCode()];
            }

            $solventWasteImpact += $solventImpact->getValue();
        }

        // Solvents impact
        foreach ($this->solvents as $solvent) {
            $solventImpact = $this->solventManager->getSolventImpact($solvent->code, $this->impactCategory);
            if (!$solventImpact) {
                return ['error' => $solvent->code];
            }

            $impact += $solvent->value * ($solventImpact->getValue() + $solventWasteImpact);
            $solventContribution += $solvent->value * ($solventImpact->getValue() + $solventWasteImpact);
        }

        // Mediums impact
        foreach ($this->mediums as $medium) {
            $mediumImpact = $this->mediumManager->getMediumImpact($medium->code, $this->impactCategory);
            if (!$mediumImpact) {
                return ['error' => $medium->code];
            }

            $impact += $mediumImpact->getValue() * $medium->value;
            $consumableContribution += $mediumImpact->getValue() * $medium->value;
        }

        // Consumables impact
        foreach ($this->consumables as $consumable) {
            $consumableImpact = $this->consumableManager->getConsumableImpact($consumable->code, $this->impactCategory);
            if (!$consumableImpact) {
                return ['error' => $consumable->code];
            }

            $impact += $consumableImpact->getValue() * $consumable->value;
            $consumableContribution += $consumableImpact->getValue() * $consumable->value;
        }

        if (0 != $duration or 0 != $impact) {
            $energy = 0.1;
            // Impact énergétique en fonction du country
            $countryImpactCategory = $this->countryManager->getCountryElectricityImpactCategory(
                $this->country, $this->impactCategory
            );

            if (!$countryImpactCategory) {
                return ['error' => 'no countryImpactCategory'];
            }

            $impact += $countryImpactCategory->getValue() * $energy;
        }

        return [
            'duration' => $duration,
            'impact' => $impact,
            'energy' => $energy,
            'energyContribution' => $energy,
            'solventContribution' => $solventContribution,
            'consumableContribution' => $consumableContribution,
        ];
    }
}
