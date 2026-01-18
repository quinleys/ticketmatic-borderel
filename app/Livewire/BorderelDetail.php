<?php

namespace App\Livewire;

use App\Services\Borderel\BorderelService;
use Livewire\Component;
use Ticketmatic\ClientException;

class BorderelDetail extends Component
{
    public int $eventId;

    public array $eventData = [];

    public array $sales = [];

    public array $totals = [];

    public bool $loading = true;

    public ?string $error = null;

    public function mount(int $event, BorderelService $borderelService): void
    {
        $this->eventId = $event;
        $this->loadBorderel($borderelService);
    }

    private function loadBorderel(BorderelService $borderelService): void
    {
        try {
            $report = $borderelService->buildReport($this->eventId);

            $this->eventData = $report->event->toArray();
            $this->sales = array_map(fn ($sale) => $sale->toArray(), $report->sales);
            $this->totals = $report->totals->toArray();

            $this->loading = false;
        } catch (ClientException $e) {
            abort(404, 'Event not found');
        } catch (\Exception $e) {
            $this->error = 'Failed to load borderel: '.$e->getMessage();
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.borderel-detail')
            ->layout('layouts.app');
    }
}
