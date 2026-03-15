<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Citizen\DashboardController as CitizenDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Citizen\RequestController as CitizenRequest;
use App\Http\Controllers\Admin\RequestAdminController as AdminRequest;
use App\Http\Controllers\Admin\DocumentTypeController as AdminDocumentType;
use App\Http\Controllers\Admin\UserController as AdminUser;

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
        Route::get('/dashboard', [CitizenDashboard::class, 'index'])->name('dashboard');

        // Demandes
        Route::get('/requests', [CitizenRequest::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [CitizenRequest::class, 'create']) ->name('requests.create');
        Route::post('/requests', [CitizenRequest::class, 'store']) ->name('requests.store');
        Route::get('/requests/{id}', [CitizenRequest::class, 'show']) ->name('requests.show');
    });

// ── Routes Admin 
Route::middleware(['auth', 'role:admin,super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Demandes
        Route::get('/requests', [AdminRequest::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [AdminRequest::class, 'show'])->name('requests.show');
        Route::post('/requests/{id}/approuver', [AdminRequest::class, 'approuver'])->name('requests.approuver');
        Route::post('/requests/{id}/rejeter', [AdminRequest::class, 'rejeter'])->name('requests.rejeter');
        Route::post('/requests/{id}/en-traitement', [AdminRequest::class, 'enTraitement'])->name('requests.enTraitement');

        // Types de documents
        Route::get('/document-types', [AdminDocumentType::class, 'index'])->name('document-types.index');
        Route::get('/document-types/create', [AdminDocumentType::class, 'create']) ->name('document-types.create');
        Route::post('/document-types', [AdminDocumentType::class, 'store']) ->name('document-types.store');
        Route::get('/document-types/{id}/edit', [AdminDocumentType::class, 'edit'])->name('document-types.edit');
        Route::put('/document-types/{id}', [AdminDocumentType::class, 'update'])->name('document-types.update');
        Route::delete('/document-types/{id}', [AdminDocumentType::class, 'destroy']) ->name('document-types.destroy');

        // Gestion utilisateurs (super_admin uniquement)
Route::middleware('role:super_admin')
    ->group(function () {
        Route::get('/users', [AdminUser::class, 'index'])
            ->name('users.index');
        Route::post('/users', [AdminUser::class, 'store'])
            ->name('users.store');
        Route::post('/users/{id}/toggle-status', [AdminUser::class, 'toggleStatus'])
            ->name('users.toggleStatus');
        Route::delete('/users/{id}', [AdminUser::class, 'destroy'])
            ->name('users.destroy');
    });
    });

require __DIR__.'/auth.php';