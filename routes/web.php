<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Citizen\DashboardController as CitizenDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

// ── Page d'accueil publique
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// ── Redirection après login selon le rôle
Route::middleware('auth')->get('/redirect', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('citizen.dashboard');
})->name('redirect');

// ── Routes Citoyen
Route::middleware(['auth', 'role:citoyen'])
    ->prefix('citizen')
    ->name('citizen.')
    ->group(function () {
        Route::get('/dashboard', [CitizenDashboard::class, 'index'])
            ->name('dashboard');
    });

// ── Routes Admin 
Route::middleware(['auth', 'role:admin,super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');
    });

require __DIR__.'/auth.php';