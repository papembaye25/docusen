<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    // ── Liste des demandes du citoyen
    public function index()
    {
        $demandes = DocumentRequest::where('user_id', auth()->id())
            ->with('documentType')
            ->latest()
            ->paginate(10);

        return view('citizen.requests.index', compact('demandes'));
    }

    // ── Formulaire nouvelle demande
    public function create()
    {
        $documentTypes = DocumentType::actif()->get();
        return view('citizen.requests.create', compact('documentTypes'));
    }

    // ── Soumettre une demande
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'document_type_id' => ['required', 'exists:document_types,id'],
            'notes_citoyen'    => ['nullable', 'string', 'max:500'],
            'fichiers'         => ['nullable', 'array', 'max:5'],
            'fichiers.*'       => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        // Upload des fichiers
        $fichiersPath = [];
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $fichier) {
                $path = $fichier->store('requests/' . auth()->id(), 'public');
                $fichiersPath[] = $path;
            }
        }

        // Créer la demande
        DocumentRequest::create([
            'user_id'          => auth()->id(),
            'document_type_id' => $request->document_type_id,
            'numero_reference' => DocumentRequest::genererReference(),
            'statut'           => 'en_attente',
            'fichiers'         => $fichiersPath,
            'notes_citoyen'    => $request->notes_citoyen,
        ]);

        return redirect()->route('citizen.requests.index')
            ->with('success', 'Votre demande a été soumise avec succès !');
    }

    // ── Détail d'une demande 
    public function show($id)
    {
        $demande = DocumentRequest::where('user_id', auth()->id())
            ->with('documentType')
            ->findOrFail($id);

        return view('citizen.requests.show', compact('demande'));
    }
}