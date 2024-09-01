<?php

namespace App\Enums;

enum StatusKaryawan: string
{
    case DRAFT = 'DRAFT';
    case SENT = 'SENT';

    public function label(): string
    {
        return match ($this) {
            StatusKaryawan::DRAFT => 'Draft',
            StatusKaryawan::SENT => 'Sent',
        };
    }
}
