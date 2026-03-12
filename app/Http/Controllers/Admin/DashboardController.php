<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\DocumentType;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistiques globales
        $stats = [
            'total_demandes'    => DocumentRequest::count(),
            'en_attente'        => DocumentRequest::where('statut', 'en_attente')->count(),
            'en_traitement'     => DocumentRequest::where('statut', 'en_traitement')->count(),
            'approuve'          => DocumentRequest::where('statut', 'approuve')->count(),
            'rejete'            => DocumentRequest::where('statut', 'rejete')->count(),
            'total_citoyens'    => User::where('role', 'citoyen')->count(),
            'total_doc_types'   => DocumentType::count(),
        ];

        // 10 dernières demandes
        $dernieresDemandes = DocumentRequest::with(['user', 'documentType'])
            ->latest()
            ->take(10)
            ->get();

        // Demandes par mois (6 derniers mois)
        $demandesParMois = DocumentRequest::selectRaw(
            'MONTH(created_at) as mois, COUNT(*) as total'
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

        return view('admin.dashboard', compact(
            'user', 'stats', 'dernieresDemandes', 'demandesParMois'
        ));
    }
}