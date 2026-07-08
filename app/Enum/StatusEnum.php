<?php

namespace App\Enum;

enum StatusEnum: string
{
    case PENDING = 'P';
    case APPROVED = 'A';
    case CANCELED = 'C';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::CANCELED => 'Canceled',
        };
    }
}
