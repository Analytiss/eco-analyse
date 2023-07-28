<?php

namespace App\Calculator;

trait CalculatorTrait
{
    private ?string $country;
    private ?string $impactCategory;
    private ?bool $activated;

    private function hasNotNullValues(array $values): bool
    {
        foreach ($values as $value) {
            if (is_null($value)) {
                return false;
            }
        }

        return true;
    }
}
