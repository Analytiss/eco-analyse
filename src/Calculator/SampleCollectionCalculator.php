<?php

namespace App\Calculator;

use App\Manager\TransportManager;

class SampleCollectionCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    private ?string $transportMode;
    private ?int $numberOfSampleCollected;
    private ?float $distance;

    public function __construct(
        private readonly TransportManager $transportManager,
    ) {
    }

    public function initData(array $data): void
    {
        $this->activated = 'true' == $data['activated'];
        $this->transportMode = $data['transportMode'] ?? null;
        $this->numberOfSampleCollected = (int) $data['numberOfSampleCollected'] ?? 0;
        $this->impactCategory = $data['impactCategory'] ?? 'gpw'; // Default : Global warming
        $this->country = $data['country'] ?? 'FR'; // Default : France
        $this->distance = match ($data['unit']) {
            'm' => (float) $data['distanceValue'] / 1000,
            default => (float) $data['distanceValue'], // Default : km
        };
    }

    public function calculation(): ?array
    {
        $values = [$this->transportMode];
        if (!$this->hasNotNullValues($values)) {
            return ['error' => 'hasNotNullValues'];
        }

        if ($this->numberOfSampleCollected < 1) {
            return ['error' => 'no samples'];
        }

        if (!$this->activated) {
            return ['error' => 'not activated'];
        }
        $transportImpact = $this->transportManager->getTransportImpact(
            $this->transportMode, $this->impactCategory
        );
        if (!$transportImpact) {
            return ['error' => 'transportImpact'];
        }
        $sampleDistance = $this->distance / $this->numberOfSampleCollected;

        $impact = $transportImpact->getValue() * $sampleDistance;

        return [
            'impact' => $impact,
            'transportContribution' => $impact,
            'distance' => $sampleDistance,
        ];
    }
}
