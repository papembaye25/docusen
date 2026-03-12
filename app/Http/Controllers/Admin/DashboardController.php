<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistiques personnelles
        $stats = [
            'total'         => DocumentRequest::where('user_id', $user->id)->count(),
            'en_attente'    => DocumentRequest::where('user_id', $user->id)
                                ->where('statut', 'en_attente')->count(),
            'en_traitement' => DocumentRequest::where('user_id', $user->id)
                                ->where('statut', 'en_traitement')->count(),
            'approuve'      => DocumentRequest::where('user_id', $user->id)
                                ->where('statut', 'approuve')->count(),
            'rejete'        => DocumentRequest::where('user_id', $user->id)
                                ->where('statut', 'rejete')->count(),
        ];

        // 5 dernières demandes
        $dernieresDemandes = DocumentRequest::where('user_id', $user->id)
            ->with('documentType')
            ->latest()
            ->take(5)
            ->get();

        return view('citizen.dashboard', compact('user', 'stats', 'dernieresDemandes'));
    }
}