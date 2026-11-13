<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin;

Route::get('/', function () {
    return Inertia::render('Home', [
        'author' => 'maurin',
    ]);
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});


// L'accueil (/) charge maintenant le ProjectController au lieu de renvoyer directement la vue Inertia
Route::get('/', [ProjectController::class, 'index'])->name('home');

// La fiche d'un projet
Route::get('projets/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');



// Le groupe sécurisé /admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projets', Admin\ProjectController::class)
        ->except('show')
        ->names('projects')
        ->parameters(['projets' => 'project']);

    Route::patch('projets/{project}/publication', [App\Http\Controllers\Admin\ProjectController::class, 'togglePublished'])
        ->name('projects.toggle-published');

    // Il faut placer monter et descendre ICI, à l'intérieur du groupe !
    Route::patch('projets/{project}/monter', [App\Http\Controllers\Admin\ProjectController::class, 'moveUp'])
        ->name('projects.move-up');

    Route::patch('projets/{project}/descendre', [App\Http\Controllers\Admin\ProjectController::class, 'moveDown'])
        ->name('projects.move-down');
});

require __DIR__ . '/settings.php';
