<?php

use App\Models\Project;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;


test('the projects page lists the published projects', function () {
    Project::factory()->count(2)->create();

    // Remplacez '/projets' par '/'
    $this->get('/')
        ->assertOk()
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('Home')
                ->has('projects', 2)
        );
});

// Test 2 : La fiche d'un projet spécifique
test('a project page shows its title', function () {
    Project::factory()->create([
        'title' => 'Météo Wavre',
        'slug' => 'meteo-wavre'
    ]);

    $this->get('/projets/meteo-wavre')
        ->assertOk()
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('projects/Show')
                ->where('project.title', 'Météo Wavre')
        );
});

// Test Bonus : Le brouillon doit renvoyer une erreur 404
test('a draft project returns a 404 error', function () {
    // On crée un brouillon exprès avec draft()
    Project::factory()->draft()->create(['slug' => 'pas-fini']);

    $this->get('/projets/pas-fini')
        ->assertNotFound(); // assertNotFound() vérifie le code 404
});


// Test 3 : Un visiteur non connecté est chassé de l'administration
test('guests cannot open the admin', function () {
    $this->get('/admin/projets')
        ->assertRedirect('/login');
});

// Test 4 : L'administrateur peut créer un projet
test('the author can create a project', function () {
    // On simule une connexion (actingAs) et on envoie un formulaire POST
    $this->actingAs(User::factory()->create())
        ->post('/admin/projets', [
            'title' => 'Mon portfolio',
            'summary' => 'Le site que vous lisez.',
        ])
        ->assertRedirect('/admin/projets')
        ->assertInertiaFlash('toast.message', 'Projet créé.'); // On vérifie la petite notif !

    // On vérifie que le projet est bien apparu dans la base de données
    expect(Project::where('slug', 'mon-portfolio')->exists())->toBeTrue();
});

// Test 5 : Si on oublie le titre, ça bloque !
test('a project without title is refused', function () {
    $this->actingAs(User::factory()->create())
        ->post('/admin/projets', [
            'title' => '',
            'summary' => 'Un résumé.'
        ])
        ->assertSessionHasErrors('title'); // Vérifie l'erreur de validation silencieuse

    // Le projet n'a pas dû être créé
    expect(Project::count())->toBe(0);
});
