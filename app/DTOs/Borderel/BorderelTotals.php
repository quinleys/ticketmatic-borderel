<?php

namespace App\DTOs\Borderel;

readonly class BorderelTotals
{
    public function __construct(
        public int $totalQty,
        public float $totalGross,
        public float $totalCost,
        public float $totalNet,
        public float $totalCostPercentage,
    ) {}

    /**
     * @param  SalesLine[]  $sales
     */
    public static function fromSales(array $sales): self
    {
        return new self(
            totalQty: (int) collect($sales)->sum('qtySold'),
            totalGross: (float) collect($sales)->sum('gross'),
            totalCost: (float) collect($sales)->sum('cost'),
            totalNet: (float) collect($sales)->sum('net'),
            totalCostPercentage: (float) collect($sales)->avg('costPercentage'),
        );
    }

    public function toArray(): array
    {
        return [
            'total_qty' => $this->totalQty,
            'total_gross' => $this->totalGross,
            'total_cost' => $this->totalCost,
            'total_net' => $this->totalNet,
            'total_cost_percentage' => $this->totalCostPercentage,
        ];
    }
}
