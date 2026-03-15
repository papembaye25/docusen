<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use App\Models\DocusenNotification;
use App\Notifications\StatusChangedNotification;

class RequestAdminController extends Controller
{
    // ── Liste toutes les demandes
    public function index(Request $request)
    {
        $query = DocumentRequest::with(['user', 'documentType'])->latest();

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par recherche
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('numero_reference', 'like', '%' . $request->search . '%');
        }

        $demandes = $query->paginate(15);

        return view('admin.requests.index', compact('demandes'));
    }

    // ── Détail d'une demande
    public function show($id)
    {
        $demande = DocumentRequest::with(['user', 'documentType'])
            ->findOrFail($id);

        return view('admin.requests.show', compact('demande'));
    }

    // ── Valider une demande
    public function approuver(Request $request, $id)
{
    $request->validate([
        'commentaire_admin' => ['nullable', 'string', 'max:500'],
    ]);

    $demande = DocumentRequest::with(['user', 'documentType'])->findOrFail($id);
    $demande->update([
        'statut'            => 'approuve',
        'commentaire_admin' => $request->commentaire_admin,
        'date_traitement'   => now(),
    ]);

    // Enregistrer la notification en base
    DocusenNotification::create([
        'user_id'         => $demande->user_id,
        'request_id'      => $demande->id,
        'message'         => "Votre demande {$demande->numero_reference} a été approuvée.",
        'type'            => 'email',
        'statut_concerne' => 'approuve',
    ]);

    // Envoyer l'email
    $demande->user->notify(new StatusChangedNotification($demande));

    return redirect()->route('admin.requests.show', $id)
        ->with('success', 'Demande approuvée et citoyen notifié !');
}

    // ── Rejeter une demande
    public function rejeter(Request $request, $id)
{
    $request->validate([
        'commentaire_admin' => ['required', 'string', 'max:500'],
    ]);

    $demande = DocumentRequest::with(['user', 'documentType'])->findOrFail($id);
    $demande->update([
        'statut'            => 'rejete',
        'commentaire_admin' => $request->commentaire_admin,
        'date_traitement'   => now(),
    ]);

    // Enregistrer la notification en base
    DocusenNotification::create([
        'user_id'         => $demande->user_id,
        'request_id'      => $demande->id,
        'message'         => "Votre demande {$demande->numero_reference} a été rejetée.",
        'type'            => 'email',
        'statut_concerne' => 'rejete',
    ]);

    // Envoyer l'email
    $demande->user->notify(new StatusChangedNotification($demande));

    return redirect()->route('admin.requests.show', $id)
        ->with('success', 'Demande rejetée et citoyen notifié.');
}

    // ── Mettre en traitement
    public function enTraitement($id)
{
    $demande = DocumentRequest::with(['user', 'documentType'])->findOrFail($id);
    $demande->update(['statut' => 'en_traitement']);

    // Enregistrer la notification en base
    DocusenNotification::create([
        'user_id'         => $demande->user_id,
        'request_id'      => $demande->id,
        'message'         => "Votre demande {$demande->numero_reference} est en cours de traitement.",
        'type'            => 'email',
        'statut_concerne' => 'en_traitement',
    ]);

    // Envoyer l'email
    $demande->user->notify(new StatusChangedNotification($demande));

    return redirect()->route('admin.requests.show', $id)
        ->with('success', 'Demande mise en traitement et citoyen notifié.');
}
}