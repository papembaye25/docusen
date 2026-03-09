<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ── Champs autorisés à l'insertion
    protected $fillable = [
        'nom',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    // Champs cachés 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting des types 
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Helpers rôles 
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isCitoyen(): bool
    {
        return $this->role === 'citoyen';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isActif(): bool
    {
        return $this->status === 'actif';
    }

    // ── Relations

    // Un utilisateur peut avoir plusieurs demandes
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    // Un utilisateur peut avoir plusieurs notifications
    public function docusenNotifications()
    {
        return $this->hasMany(DocusenNotification::class);
    }
}