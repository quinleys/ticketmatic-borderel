<?php

namespace App\Services\Borderel;

use App\DTOs\Borderel\BorderelSalesLine;
use App\DTOs\Borderel\BorderelEvent;
use App\DTOs\Borderel\BorderelReport;
use App\DTOs\Borderel\BorderelTotals;
use App\Services\Ticketmatic\TicketmaticClient;

class BorderelService
{
    public function __construct(private TicketmaticClient $ticketmaticClient, private CostRules $costRules) {}

    public function buildReport(int $eventId): BorderelReport
    {
        try {
            $event = $this->ticketmaticClient->getEvent($eventId);

            if (! $event) {
                throw new \Exception('Event not found');
            }

            $salesForEventPerPriceType = $this->ticketmaticClient->getSalesData($eventId);

            if (! $salesForEventPerPriceType) {
                throw new \Exception('Sales not found');
            }

            $sales = $this->calculateCostsForEventPerPriceType($salesForEventPerPriceType);

            return new BorderelReport(
                event: BorderelEvent::fromTicketmaticEvent($event),
                sales: $sales,
                totals: BorderelTotals::fromSales($sales),
            );
        } catch (\Exception $e) {
            throw new \Exception('Failed to build report: '.$e->getMessage());
        }
    }

    private function calculateCostsForEventPerPriceType(array $salesForEventPerPriceType): array
    {
        return collect($salesForEventPerPriceType)->map(function ($sale) {
            $costPercentage = $this->costRules->ruleFor((string) $sale['pricetypeid'])['cost_percentage'];
            $cost = $sale['gross'] * $costPercentage;
            $net = $sale['gross'] - $cost;

            return BorderelSalesLine::fromArray([
                ...$sale,
                'cost' => $cost,
                'net' => $net,
                'cost_percentage' => $costPercentage,
            ]);
        })->toArray();
    }
}
