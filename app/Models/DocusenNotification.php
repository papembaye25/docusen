<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocusenNotification extends Model
{
    use HasFactory;

    // ── Champs autorisés
    protected $fillable = [
        'user_id',
        'request_id',
        'message',
        'type',
        'statut_concerne',
        'lu',
        'lu_at',
    ];

    // ── Casting des type
    protected $casts = [
        'lu'    => 'boolean',
        'lu_at' => 'datetime',
    ];

    // ── Relations

    // Une notification appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une notification appartient à une demande
    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class, 'request_id');
    }

    // ── Marquer comme lue
    public function marquerLue(): void
    {
        $this->update([
            'lu'    => true,
            'lu_at' => now(),
        ]);
    }

    // ── Scope : notifications non lues
    public function scopeNonLues($query)
    {
        return $query->where('lu', false);
    }
}