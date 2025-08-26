<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        // Basic role check - can be extended with proper role system
        // For now, allow all authenticated users admin access for development
        if ($role === 'admin') {
            return true; // Temporarily allow all users admin access
            // return $this->email === 'admin@example.com' || 
            //        str_ends_with($this->email, '@admin.com');
        }
        
        return false;
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        // Basic permission check - can be extended with proper permission system
        if ($this->hasRole('admin')) {
            return true; // Admins have all permissions
        }
        
        // Add specific permission logic here
        return false;
    }

    /**
     * Get user role for display
     */
    public function getRoleAttribute(): string
    {
        if ($this->hasRole('admin')) {
            return 'Admin';
        }
        
        return 'User';
    }
}
