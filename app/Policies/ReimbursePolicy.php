<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Enums\StatusKaryawan;
use App\Models\Reimburse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReimbursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            RolesEnum::SUPERADMIN,
            RolesEnum::FINANCE,
            RolesEnum::HR,
            RolesEnum::KARYAWAN,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reimburse $reimburse): bool
    {
        if ($user->hasRole(RolesEnum::FINANCE)) {
            return $reimburse->isHrAccept();
        }

        if ($user->hasRole(RolesEnum::HR)) {
            return $reimburse->isKaryawanSent();
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RolesEnum::KARYAWAN);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reimburse $reimburse): bool
    {
        return $user->hasRole('karyawan') && $reimburse->isKaryawanDraft();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reimburse $reimburse): bool
    {
        if ($user->hasRole(RolesEnum::KARYAWAN) && $reimburse->isKaryawanDraft()) {
            return true;
        }
        return false;
    }

    public function sendReimburse(User $user, Reimburse $reimburse)
    {
        return $reimburse->isKaryawanDraft() && $user->hasRole(RolesEnum::KARYAWAN);
    }

    public function hrAccept(User $user, Reimburse $reimburse)
    {
        return $reimburse->isKaryawanSent() && $user->hasRole(RolesEnum::HR) && !$reimburse->isHrAccept();
    }

    public function hrReject(User $user, Reimburse $reimburse)
    {
        return $reimburse->isKaryawanSent() && $user->hasRole(RolesEnum::HR) && !$reimburse->isHrAccept();
    }

    public function financeAccept(User $user, Reimburse $reimburse)
    {
        return $reimburse->isHrAccept() && $user->hasRole(RolesEnum::FINANCE) && !$reimburse->isFinanceAccept() && !$reimburse->isFinanceFinish();
    }

    public function financeReject(User $user, Reimburse $reimburse)
    {
        return $reimburse->isHrAccept() && $user->hasRole(RolesEnum::FINANCE) && !$reimburse->isFinanceAccept() && !$reimburse->isFinanceFinish();
    }

    public function financeFinish(User $user, Reimburse $reimburse)
    {
        return $reimburse->isFinanceAccept();
    }
}
