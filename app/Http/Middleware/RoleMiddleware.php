<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Vérifier que l'utilisateur est connecté
        if (! auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté.');
        }

        $user = auth()->user();

        // 2. Vérifier que le compte n'est pas suspendu
        if ($user->status === 'suspendu') {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte a été suspendu.');
        }

        // 3. Vérifier le rôle
        if (! in_array($user->role, $roles)) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('warning', 'Accès non autorisé.');
            }
            return redirect()->route('citizen.dashboard')
                ->with('warning', 'Accès non autorisé.');
        }

        return $next($request);
    }
}