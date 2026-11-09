<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;

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


require __DIR__.'/settings.php';
