<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Liste tous les admins
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->latest()
            ->get();

        $citoyens = User::where('role', 'citoyen')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('admins', 'citoyens'));
    }

    // ── Créer un admin
    public function store(Request $request)
    {
        $request->validate([
            'nom'   => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role'  => ['required', 'in:admin,super_admin'],
        ]);

        User::create([
            'nom'      => $request->nom,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make('Admin@2026'),
            'role'     => $request->role,
            'status'   => 'actif',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Compte admin créé avec succès ! Mot de passe par défaut : Admin@2026');
    }

    // ── Suspendre / Activer un utilisateur
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Empêcher de suspendre son propre compte
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas suspendre votre propre compte.');
        }

        $user->update([
            'status' => $user->status === 'actif' ? 'suspendu' : 'actif'
        ]);

        $message = $user->status === 'actif' ? 'Compte activé.' : 'Compte suspendu.';

        return back()->with('success', $message);
    }

    // ── Supprimer un admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Compte supprimé avec succès.');
    }
}