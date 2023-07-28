<?php

namespace App\Calculator;

use App\Manager\CountryManager;
use App\Manager\DeviceManager;
use App\Manager\GasManager;
use App\Model\Gradient;

class SampleAnalysisCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    private const TECHNIQUES = [
        'gc' => ['gas_chromatograph_6890_bua'],
        'gc_ms' => ['gas_chromatograph_6890_bua', 'mass_spectrometer_5973_bua'],
    ];
    private const HOLD_TIME = 500;
    private const MASS_CONSUMPTION = 0.25;

    private ?float $duration;
    private ?string $analyticalTechnic;
    private ?bool $directMeasurement;
    private ?float $consumption;
    private ?string $gas;
    private ?float $flowRate = 25;
    private array|string|null $ovenGradient = null;

    public function __construct(
        private readonly GasManager $gasManager,
        private readonly CountryManager $countryManager,
        private readonly DeviceManager $deviceManager,
    ) {
    }

    public function initData(array $data): void
    {
        $this->activated = 'true' == $data['activated'];
        $this->analyticalTechnic = $data['analyticalTechnic'] ?? 'gc'; // Default : gc
        $this->directMeasurement = 'true' == $data['directMeasurement'];
        $this->duration = match ($data['durationUnit']) {
            'm' => (float) $data['durationValue'] / 60,
            default => (float) $data['durationValue'], // Default : h
        };
        $this->impactCategory = $data['impactCategory'] ?? 'gpw'; // Default : Global warming
        $this->country = $data['country'] ?? 'FR'; // Default : France
        $this->gas = $data['gas'] ?? null;
        $this->consumption = (float) $data['consumption'] ?? 0;
        $this->ovenGradient = $data['ovenGradient'];
    }

    public function calculation(): ?array
    {
        $deviceContribution = 0;
        $gasContribution = 0;
        if (!$this->hasNotNullValues([$this->gas, $this->analyticalTechnic])) {
            return ['error' => 'hasNotNullValues'];
        }

        $duration = $this->duration * 60;
        if (!$this->activated) {
            return ['error' => 'not activated'];
        }

        // Impact energy
        $energy = 0;
        if ($this->directMeasurement) {
            $energy = $this->consumption / 1000;
        } else {
            if ($this->ovenGradient) {
                $this->ovenGradient = explode(';', $this->ovenGradient);
                foreach ($this->ovenGradient as $g => $gradient) {
                    $this->ovenGradient[$g] = new Gradient(explode(',', $this->ovenGradient[$g]));
                }
            } else {
                return ['error' => 'ovenGradient'];
            }

            if (is_string($this->ovenGradient)) {
                return ['error' => 'ovenGradient'];
            } else {
                $lastPoint = $this->ovenGradient[0]->getSetPoint();
                $energy += (self::HOLD_TIME * ($this->ovenGradient[0]->getHoldTime() / 60)) / 1000;
                foreach (array_slice($this->ovenGradient, 1) as $gradient) {
                    $timeToUp = $this->timeForTempGrowUp($lastPoint, $gradient->getSetPoint(), $gradient->getRate());
                    $power = $this->gradientRatePower($gradient->getRate());

                    $energy += ($power * ($timeToUp / 60)) / 1000; // (P * T) / 1000 => kWh
                    $energy += (self::HOLD_TIME * ($gradient->getHoldTime() / 60)) / 1000;

                    $lastPoint = $gradient->getSetPoint();
                }
            }

            // Si le temps d'analyse saisie est différent du temps d'analyse calculé, on prend le tps calculé
            if (round($this->duration * 60, 3) != round(end($this->ovenGradient)->getRunTime(), 3)) {
                $duration = end($this->ovenGradient)->getRunTime();
            }
        }

        $impact = 0;

        // Impact du gaz
        if (!$gasImpact = $this->gasManager->getGasImpact($this->gas, $this->impactCategory)) {
            return ['error' => 'gasImpact'];
        }
        $gasContribution += $gasImpact->getValue() * $this->flowRate * $duration;
        $impact += $gasImpact->getValue() * $this->flowRate * $duration;

        // Ajout l'amortissement du PC
        $energy += self::ENERGY_CONSUMPTION * ($duration / 60);
        foreach (self::DEVICES as $device) {
            if (!$deviceImpact = $this->deviceManager->getDeviceImpact($device, $this->impactCategory)) {
                return ['error' => $device];
            }

            $impact += ($duration / 60) * $deviceImpact->getValue();
            $deviceContribution += ($duration / 60) * $deviceImpact->getValue();
        }

        // Ajout l'amortissement de l'appareil
        foreach (self::TECHNIQUES[$this->analyticalTechnic] as $technique) {
            if (!$deviceImpact = $this->deviceManager->getDeviceImpact($technique, $this->impactCategory)) {
                return ['error' => $technique];
            }

            $energy += $deviceImpact->getValue();
            $impact += ($duration / 60) * $deviceImpact->getValue();
            $deviceContribution += ($duration / 60) * $deviceImpact->getValue();

            if ('mass_spectrometer_5973_bua' == $technique) {
                $energy += self::MASS_CONSUMPTION * ($duration / 60);
            }
        }

        // Impact en fonction du country
        $countryImpactCategory = $this->countryManager->getCountryElectricityImpactCategory(
            $this->country, $this->impactCategory
        );

        if (!$countryImpactCategory) {
            return ['error' => 'no countryImpactCategory'];
        }

        $impact += $countryImpactCategory->getValue() * $energy;

        return [
            'duration' => $duration,
            'impact' => $impact,
            'energy' => $energy,
            'energyContribution' => $energy,
            'gasContribution' => $gasContribution,
            'deviceContribution' => $deviceContribution,
        ];
    }

    private function timeForTempGrowUp(float $start, float $end, float $rate): float
    {
        return ($end - $start) / $rate;
    }

    private function gradientRatePower(float $rate): float
    {
        return 198.36 * exp(0.0537 * $rate);
    }
}
