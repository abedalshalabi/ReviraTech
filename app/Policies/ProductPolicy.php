<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all authenticated users to view products list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        // Allow all authenticated users to view individual products
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only allow users with admin role or specific permission
        return $this->isAdmin($user) || $this->hasPermission($user, 'create_products');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Only allow users with admin role or specific permission
        return $this->isAdmin($user) || $this->hasPermission($user, 'edit_products');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Only allow users with admin role or specific permission
        return $this->isAdmin($user) || $this->hasPermission($user, 'delete_products');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if user is admin
     */
    private function isAdmin(User $user): bool
    {
        // Check if user has admin role (you can implement role system)
        return $user->email === 'admin@example.com' || 
               (method_exists($user, 'hasRole') && $user->hasRole('admin'));
    }

    /**
     * Check if user has specific permission
     */
    private function hasPermission(User $user, string $permission): bool
    {
        // Basic permission check - can be extended with proper permission system
        if (method_exists($user, 'hasPermission')) {
            return $user->hasPermission($permission);
        }
        
        // Fallback: check user attributes or implement basic permission logic
        return false;
    }
}