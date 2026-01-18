<?php

namespace App\Services\Ticketmatic;

use Ticketmatic\Client;
use Ticketmatic\Endpoints\Events;
use Ticketmatic\Endpoints\EventsList;
use Ticketmatic\Endpoints\Tools;
use Ticketmatic\Model\Event;
use Ticketmatic\Model\QueryResult;

class TicketmaticClient
{
    private Client $client;

    public function __construct()
    {
        $apiUrl = config('ticketmatic.api_url');
        if ($apiUrl) {
            Client::$server = $apiUrl;
        }

        $this->client = new Client(
            config('ticketmatic.account_name'),
            config('ticketmatic.api_key'),
            config('ticketmatic.api_secret')
        );
    }

    /**
     * Get a list of events.
     *
     * @param  array<string, mixed>  $params
     */
    public function listEvents(array $params = []): EventsList
    {
        return Events::getlist($this->client, $params);
    }

    /**
     * Get a single event by ID.
     */
    public function getEvent(int $id): Event
    {
        return Events::get($this->client, $id);
    }

    public function getSalesData(int $eventId): array
    {
        $queryString = $this->salesByPriceTypeSql($eventId, true);

        $result = $this->query(query: $queryString);

        return array_map(fn ($row) => (array) $row, $result->results);
    }

    /**
     * Execute a query on the public data model.
     */
    public function query(string $query, ?int $limit = null, ?int $offset = null): QueryResult
    {
        $data = ['query' => $query];

        if ($limit !== null) {
            $data['limit'] = $limit;
        }

        if ($offset !== null) {
            $data['offset'] = $offset;
        }

        return Tools::queries($this->client, $data);
    }

    private function salesByPriceTypeSql(int $eventId, bool $includeFee): string
    {
        $eventId = (int) $eventId; // safety: only allow int injection

        $grossExpr = $includeFee
            ? 'SUM(t.price + COALESCE(t.orderfee, 0))'
            : 'SUM(t.price)';

        return "
            SELECT
              ttp.pricetypeid,
              pt.nameen AS pricetype_name,
              COUNT(*) AS qty_sold,
              {$grossExpr} AS gross
            FROM tm.ticket t
            JOIN tm.tickettype tt ON tt.id = t.tickettypeid
            JOIN tm.tickettypeprice ttp ON ttp.id = t.tickettypepriceid
            JOIN tm.pricetype pt ON pt.id = ttp.pricetypeid
            WHERE tt.eventid = {$eventId}
              AND t.orderid IS NOT NULL
              AND t.currentstatus IN (101, 103)
            GROUP BY ttp.pricetypeid, pt.nameen
            ORDER BY pt.nameen
        ";
    }
}
