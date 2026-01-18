<?php

namespace App\Livewire;

use App\DTOs\EventSummary;
use App\Services\Ticketmatic\TicketmaticClient;
use Livewire\Component;

class EventsList extends Component
{
    public array $events = [];

    public ?int $selectedEventId = null;

    public bool $loading = true;

    public ?string $error = null;

    public function mount(TicketmaticClient $ticketmaticClient): void
    {
        $this->loadEvents($ticketmaticClient);
    }

    private function loadEvents(TicketmaticClient $ticketmaticClient): void
    {
        try {
            $eventsList = $ticketmaticClient->listEvents();
            $this->events = array_map(
                fn ($event) => EventSummary::fromTicketmaticEvent($event)->toArray(),
                $eventsList->data ?? []
            );
            $this->loading = false;
        } catch (\Exception $e) {
            $this->error = 'Failed to load events: '.$e->getMessage();
            $this->loading = false;
        }
    }

    public function viewBorderel(): void
    {
        if ($this->selectedEventId === null) {
            return;
        }

        $this->redirect(route('events.borderel', ['event' => $this->selectedEventId]));
    }

    public function render()
    {
        return view('livewire.events-list')
            ->layout('layouts.app');
    }
}
