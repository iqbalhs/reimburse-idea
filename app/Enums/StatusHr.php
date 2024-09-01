<?php

namespace App\Enums;

enum StatusHr: string
{
    case REVIEW = 'REVIEW';
    case ACCEPT = 'ACCEPT';
    case REJECT = 'REJECT';

    public function label(): string
    {
        return match ($this) {
            StatusHr::REVIEW => 'Review',
            StatusHr::ACCEPT => 'Accept',
            StatusHr::REJECT => 'Reject',
        };
    }
}
