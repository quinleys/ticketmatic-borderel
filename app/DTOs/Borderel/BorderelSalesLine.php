<?php

namespace App\DTOs\Borderel;

readonly class BorderelSalesLine
{
    public function __construct(
        public int $pricetypeId,
        public string $pricetypeName,
        public int $qtySold,
        public float $gross,
        public float $cost,
        public float $net,
        public float $costPercentage,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            pricetypeId: (int) $data['pricetypeid'],
            pricetypeName: (string) ($data['pricetype_name'] ?? ''),
            qtySold: (int) $data['qty_sold'],
            gross: (float) $data['gross'],
            cost: (float) $data['cost'],
            net: (float) $data['net'],
            costPercentage: (float) $data['cost_percentage'],
        );
    }

    public function toArray(): array
    {
        return [
            'pricetype_id' => $this->pricetypeId,
            'pricetype_name' => $this->pricetypeName,
            'qty_sold' => $this->qtySold,
            'gross' => $this->gross,
            'cost' => $this->cost,
            'net' => $this->net,
            'cost_percentage' => $this->costPercentage,
        ];
    }
}
