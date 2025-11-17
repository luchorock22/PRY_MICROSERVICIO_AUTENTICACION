<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // --- ROLES ---
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_USER = 'user';

    // Campos permitidos
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Campos ocultos
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Convertir campos automáticamente
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- MÉTODOS DE ROLES ---
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    // --- LISTA DE ROLES ---
    public static function availableRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_EDITOR,
            self::ROLE_USER,
        ];
    }
}

