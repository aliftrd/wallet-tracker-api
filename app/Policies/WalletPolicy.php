<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Wallet');
    }

    public function view(AuthUser $authUser, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $authUser->id === $wallet->user_id && $authUser->can('View:Wallet');
        }

        return $authUser->can('View:Wallet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Wallet');
    }

    public function update(AuthUser $authUser, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $authUser->id === $wallet->user_id && $authUser->can('Update:Wallet');
        }

        return $authUser->can('Update:Wallet');
    }

    public function delete(AuthUser $authUser, Wallet $wallet): bool
    {
        if (request()->is('api/*')) {
            return $authUser->id === $wallet->user_id && $authUser->can('Delete:Wallet');
        }

        return $authUser->can('Delete:Wallet');
    }
}
