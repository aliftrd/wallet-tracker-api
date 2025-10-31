<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ViewAny:Wallet');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $wallet->user_id && $user->can('View:Wallet');
        }

        return $user->can('View:Wallet');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Create:Wallet');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $wallet->user_id && $user->can('Update:Wallet');
        }

        return $user->can('Update:Wallet');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $wallet->user_id && $user->can('Delete:Wallet');
        }

        return $user->can('Delete:Wallet');
    }
}
