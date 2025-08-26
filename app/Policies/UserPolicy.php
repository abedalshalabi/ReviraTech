<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only admins can view user list
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Users can view their own profile, admins can view any
        return $user->id === $model->id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins can create users
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile, admins can update any
        return $user->id === $model->id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only admins can delete users, but not themselves
        return $this->isAdmin($user) && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $this->isAdmin($user) && $user->id !== $model->id;
    }

    /**
     * Check if user is admin
     */
    private function isAdmin(User $user): bool
    {
        return $user->email === 'admin@example.com' || 
               (method_exists($user, 'hasRole') && $user->hasRole('admin'));
    }
}