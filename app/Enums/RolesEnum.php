<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'superadmin';
    case FINANCE = 'finance';
    case HR = 'hr';
    case KARYAWAN = 'karyawan';

    public function label(): string
    {
        return match ($this) {
            RolesEnum::SUPERADMIN => 'Superadmin',
            RolesEnum::FINANCE => 'Finance',
            RolesEnum::HR => 'HR',
            RolesEnum::KARYAWAN => 'Karyawan',
        };
    }
}
