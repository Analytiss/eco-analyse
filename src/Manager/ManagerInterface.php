<?php

namespace App\Manager;

interface ManagerInterface
{
    public function getAll(): array;

    public function addImpactCategory(string $entityCode, string $impactCategoryCode, float $value);

    public function addLabel(string $code, string $label);
}
