<?php

namespace App\Traits;

use Illuminate\Support\Number;

trait UseFormattedCurrency
{
    protected function formatCurrency($amount, string $currency = 'IDR'): array
    {
        return [
            'original' => $amount,
            'formatted' => Number::currency($amount, $currency),
        ];
    }
}
