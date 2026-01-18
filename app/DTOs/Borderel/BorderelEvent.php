<?php

namespace App\DTOs\Borderel;

use App\EventStatus;
use Ticketmatic\Model\Event;

readonly class BorderelEvent
{
    public function __construct(
        public int $id,
        public string $name,
        public string $subtitle,
        public string $description,
        public ?string $startts,
        public ?string $endts,
        public string $locationname,
        public EventStatus $currentstatus,
        public string $code,
    ) {}

    public static function fromTicketmaticEvent(Event $event): self
    {
        return new self(
            id: (int) $event->id,
            name: (string) ($event->name ?? ''),
            subtitle: (string) ($event->subtitle ?? ''),
            description: (string) ($event->description ?? ''),
            startts: $event->startts?->format('l, F j, Y \a\t H:i'),
            endts: $event->endts?->format('l, F j, Y \a\t H:i'),
            locationname: (string) ($event->locationname ?? ''),
            currentstatus: EventStatus::from($event->currentstatus ?? 0),
            code: (string) ($event->code ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'startts' => $this->startts,
            'endts' => $this->endts,
            'locationname' => $this->locationname,
            'currentstatus' => $this->currentstatus,
            'code' => $this->code,
        ];
    }
}
