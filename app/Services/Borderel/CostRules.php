<?php

namespace App\Services\Borderel;

class CostRules
{
    public function ruleFor(int $priceTypeId): array
    {
        $specific = config("borderel.price_types.{$priceTypeId}");

        return $specific ?? config('borderel.default');
    }
}
