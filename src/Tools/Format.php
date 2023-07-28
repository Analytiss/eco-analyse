<?php

namespace App\Tools;

class Format
{
    public static function getFileExtension(string $fileName): string
    {
        return explode('.', $fileName)[count(explode('.', $fileName)) - 1];
    }

    public static function transformScientificToDecimal(string $scientific, int $numberOfDecimal = 50): float
    {
        // Convertir la valeur en nombre décimal en utilisant floatval()
        $decimalValue = floatval(str_replace(',', '.', $scientific));

        // Formater le nombre décimal en utilisant number_format()
        return number_format($decimalValue, $numberOfDecimal, '.', '');
    }
}
