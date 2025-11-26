<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Menentukan siapa yang boleh melihat menu "Users" di sidebar.
     */
    public function viewAny(User $user): bool
    {
    return $user->isOwner();
    }

    /**
     * Menentukan siapa yang boleh melihat detail user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Menentukan siapa yang boleh membuat user baru.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Menentukan siapa yang boleh edit user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Menentukan siapa yang boleh hapus user.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role_id === 1;
    }
}