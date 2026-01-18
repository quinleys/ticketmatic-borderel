<?php

namespace App\DTOs;

use Ticketmatic\Model\Event;

readonly class EventSummary
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $startts,
        public ?string $locationname,
    ) {}

    public static function fromTicketmaticEvent(Event $event): self
    {
        return new self(
            id: (int) $event->id,
            name: (string) $event->name,
            startts: $event->startts?->format('Y-m-d H:i'),
            locationname: $event->locationname,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'startts' => $this->startts,
            'locationname' => $this->locationname,
        ];
    }
}
