<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserCategory');
    }

    public function view(AuthUser $authUser, UserCategory $userCategory): bool
    {
        return $authUser->can('View:UserCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserCategory');
    }

    public function update(AuthUser $authUser, UserCategory $userCategory): bool
    {
        return $authUser->can('Update:UserCategory');
    }

    public function delete(AuthUser $authUser, UserCategory $userCategory): bool
    {
        return $authUser->can('Delete:UserCategory');
    }
}
