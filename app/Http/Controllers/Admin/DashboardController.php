<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistiques de base pour le dashboard
        $stats = [
            'total_users'    => User::where('role', 'citoyen')->count(),
            'total_admins'   => User::whereIn('role', ['admin', 'super_admin'])->count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }
}