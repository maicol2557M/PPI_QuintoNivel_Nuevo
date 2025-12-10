<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Solo administradores pueden gestionar usuarios.
     */
    public function isAdmin(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function viewAny(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function view(User $user, User $model)
    {
        return $user->rol === 'Administrador';
    }

    public function create(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function update(User $user, User $model)
    {
        return $user->rol === 'Administrador';
    }

    public function delete(User $user, User $model)
    {
        return $user->rol === 'Administrador';
    }
}
