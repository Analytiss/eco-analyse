<?php

namespace App\Calculator;

interface CalculatorInterface
{
    public const ENERGY_CONSUMPTION = 0.007;

    public const DEVICES = ['desktop_computer_bau', 'lcd_display_bau'];

    public function initData(array $data): void;

    public function calculation(): ?array;
}
