<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

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

        $demande = DocumentRequest::findOrFail($id);
        $demande->update([
            'statut'            => 'approuve',
            'commentaire_admin' => $request->commentaire_admin,
            'date_traitement'   => now(),
        ]);

        return redirect()->route('admin.requests.show', $id)
            ->with('success', 'Demande approuvée avec succès !');
    }

    // ── Rejeter une demande
    public function rejeter(Request $request, $id)
    {
        $request->validate([
            'commentaire_admin' => ['required', 'string', 'max:500'],
        ]);

        $demande = DocumentRequest::findOrFail($id);
        $demande->update([
            'statut'            => 'rejete',
            'commentaire_admin' => $request->commentaire_admin,
            'date_traitement'   => now(),
        ]);

        return redirect()->route('admin.requests.show', $id)
            ->with('success', 'Demande rejetée.');
    }

    // ── Mettre en traitement
    public function enTraitement($id)
    {
        $demande = DocumentRequest::findOrFail($id);
        $demande->update(['statut' => 'en_traitement']);

        return redirect()->route('admin.requests.show', $id)
            ->with('success', 'Demande mise en traitement.');
    }
}