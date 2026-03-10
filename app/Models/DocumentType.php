<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    // ── Champs autorisés
    protected $fillable = [
        'nom',
        'description',
        'conditions',
        'delai_traitement',
        'actif',
    ];

    // ── Casting des types
    protected $casts = [
        'actif'            => 'boolean',
        'delai_traitement' => 'integer',
    ];

    // ── Scope : uniquement les types actifs
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    // ── Relation : un type a plusieurs demandes
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }
}