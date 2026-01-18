<?php

namespace App;

enum EventStatus: int
{
    case DRAFT = 19001;
    case ACTIVE = 19002;
    case CLOSED = 19003;
    case UNKNOWN = 0;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::CLOSED => 'Closed',
            default => 'Unknown',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            self::ACTIVE => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            self::CLOSED => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            self::UNKNOWN => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
        };
    }
}
