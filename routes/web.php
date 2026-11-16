<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;

// ROUTE ACCUEIL UNIQUE (qui charge Home.vue via le contrôleur pour avoir les projets)
Route::get('/', [ProjectController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// La fiche d'un projet
Route::get('projets/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

// Le contact
Route::get('contact', [ContactController::class, 'create'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->middleware('throttle:3,1')->name('contact.store');

// Les mentions légales
Route::inertia('mentions-legales', 'Legal')->name('legal');

// Le groupe sécurisé /admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projets', Admin\ProjectController::class)
        ->except('show')
        ->names('projects')
        ->parameters(['projets' => 'project']);

    Route::patch('projets/{project}/publication', [App\Http\Controllers\Admin\ProjectController::class, 'togglePublished'])
        ->name('projects.toggle-published');

    Route::patch('projets/{project}/monter', [App\Http\Controllers\Admin\ProjectController::class, 'moveUp'])
        ->name('projects.move-up');

    Route::patch('projets/{project}/descendre', [App\Http\Controllers\Admin\ProjectController::class, 'moveDown'])
        ->name('projects.move-down');
});

require __DIR__ . '/settings.php';
