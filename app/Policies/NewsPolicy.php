<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, News $news): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $this->hasPermission($user, 'create_news');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        return $this->isAdmin($user) || $this->hasPermission($user, 'edit_news');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        return $this->isAdmin($user) || $this->hasPermission($user, 'delete_news');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, News $news): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, News $news): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if user is admin
     */
    private function isAdmin(User $user): bool
    {
        return $user->email === 'admin@example.com' || 
               (method_exists($user, 'hasRole') && $user->hasRole('admin'));
    }

    /**
     * Check if user has specific permission
     */
    private function hasPermission(User $user, string $permission): bool
    {
        if (method_exists($user, 'hasPermission')) {
            return $user->hasPermission($permission);
        }
        
        return false;
    }
}