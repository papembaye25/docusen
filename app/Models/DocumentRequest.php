<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    // ── Champs autorisés
    protected $fillable = [
        'user_id',
        'document_type_id',
        'numero_reference',
        'statut',
        'fichiers',
        'commentaire_admin',
        'notes_citoyen',
        'date_traitement',
    ];

    // ── Casting des types
    protected $casts = [
        'fichiers'         => 'array',
        'date_traitement'  => 'datetime',
    ];

    // ── Relations

    // Une demande appartient à un citoyen
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une demande appartient à un type de document
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    // ── Helpers statuts
    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    public function isEnTraitement(): bool
    {
        return $this->statut === 'en_traitement';
    }

    public function isApprouve(): bool
    {
        return $this->statut === 'approuve';
    }

    public function isRejete(): bool
    {
        return $this->statut === 'rejete';
    }

    // ── Générer un numéro de référence unique
    public static function genererReference(): string
    {
        $annee  = date('Y');
        $dernier = self::whereYear('created_at', $annee)->count() + 1;
        return 'DOC-' . $annee . '-' . str_pad($dernier, 4, '0', STR_PAD_LEFT);
    }

    // ── Label du statut 
    public function statutLabel(): string
    {
        return match($this->statut) {
            'en_attente'    => 'En attente',
            'en_traitement' => 'En traitement',
            'approuve'      => 'Approuvé',
            'rejete'        => 'Rejeté',
            default         => 'Inconnu',
        };
    }

    // ── Couleur badge du statut
    public function statutBadge(): string
    {
        return match($this->statut) {
            'en_attente'    => 'bg-orange-100 text-orange-700',
            'en_traitement' => 'bg-blue-100 text-blue-700',
            'approuve'      => 'bg-green-100 text-green-700',
            'rejete'        => 'bg-red-100 text-red-700',
            default         => 'bg-gray-100 text-gray-700',
        };
    }
}