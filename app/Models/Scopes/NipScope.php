<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class NipScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        // Get the currently authenticated user
        $user = Auth::user();
        // Check if the user has the "kayawan" role
        if ($user->hasRole('karyawan')) {
            // Apply a query filter that only allows users to see records where 'nip' matches their own 'nip'
            $builder->where('nip', $user->nip);
        }
    }
}
