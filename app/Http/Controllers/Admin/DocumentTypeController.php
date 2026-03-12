<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    // ── Liste tous les types
    public function index()
    {
        $types = DocumentType::latest()->paginate(10);
        return view('admin.document-types.index', compact('types'));
    }

    // ── Formulaire création
    public function create()
    {
        return view('admin.document-types.create');
    }

    // ── Enregistrer un nouveau type
    public function store(Request $request)
    {
        $request->validate([
            'nom'              => ['required', 'string', 'max:150'],
            'description'      => ['nullable', 'string'],
            'conditions'       => ['nullable', 'string'],
            'delai_traitement' => ['required', 'integer', 'min:1'],
            'actif'            => ['boolean'],
        ]);

        DocumentType::create([
            'nom'              => $request->nom,
            'description'      => $request->description,
            'conditions'       => $request->conditions,
            'delai_traitement' => $request->delai_traitement,
            'actif'            => $request->boolean('actif', true),
        ]);

        return redirect()->route('admin.document-types.index')
            ->with('success', 'Type de document créé avec succès !');
    }

    // ── Formulaire modification
    public function edit($id)
    {
        $type = DocumentType::findOrFail($id);
        return view('admin.document-types.edit', compact('type'));
    }

    // ── Mettre à jour un type
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'              => ['required', 'string', 'max:150'],
            'description'      => ['nullable', 'string'],
            'conditions'       => ['nullable', 'string'],
            'delai_traitement' => ['required', 'integer', 'min:1'],
        ]);

        $type = DocumentType::findOrFail($id);
        $type->update([
            'nom'              => $request->nom,
            'description'      => $request->description,
            'conditions'       => $request->conditions,
            'delai_traitement' => $request->delai_traitement,
            'actif'            => $request->boolean('actif', false),
        ]);

        return redirect()->route('admin.document-types.index')
            ->with('success', 'Type de document mis à jour !');
    }

    // ── Supprimer un type
    public function destroy($id)
    {
        $type = DocumentType::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.document-types.index')
            ->with('success', 'Type de document supprimé.');
    }
}