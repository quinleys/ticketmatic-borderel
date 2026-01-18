<?php

namespace App\DTOs\Borderel;

readonly class BorderelReport
{
    public function __construct(
        public BorderelEvent $event,
        public array $sales,
        public BorderelTotals $totals,
    ) {}
}
