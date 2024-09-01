<?php

namespace App\Enums;

enum StatusFinance: string
{
    case REVIEW = 'REVIEW';
    case ACCEPT = 'ACCEPT';
    case REJECT = 'REJECT';
    case FINISH = 'FINISH';

    public function label(): string
    {
        return match ($this) {
            StatusFinance::REVIEW => 'Review',
            StatusFinance::ACCEPT => 'Accept',
            StatusFinance::REJECT => 'Reject',
            StatusFinance::FINISH => 'Finish',
        };
    }
}
