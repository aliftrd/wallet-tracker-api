<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AppConfig;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppConfigPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AppConfig');
    }

    public function view(AuthUser $authUser, AppConfig $appConfig): bool
    {
        return $authUser->can('View:AppConfig');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AppConfig');
    }

    public function update(AuthUser $authUser, AppConfig $appConfig): bool
    {
        return $authUser->can('Update:AppConfig');
    }

    public function delete(AuthUser $authUser, AppConfig $appConfig): bool
    {
        return $authUser->can('Delete:AppConfig');
    }
}
