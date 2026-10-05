<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin';
    }

    public function isCustomer(): bool
    {
        return strtolower($this->role) === 'customer';
    }

    /**
     * Cek apakah user memiliki role tertentu.
     * Dapat menerima string tunggal atau array role.
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }
}