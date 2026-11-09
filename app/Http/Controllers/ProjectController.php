<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        // 1. On récupère les projets depuis la base de données
        $projects = Project::with('tags')
            ->orderBy('position')
            ->get()
            ->map(fn(Project $project) => [
                'title' => $project->title,
                'slug' => $project->slug,
                'summary' => $project->summary,
                'cover_url' => $project->cover_path
                    ? Storage::disk('public')->url($project->cover_path)
                    : null,
                'tags' => $project->tags->pluck('name'),
            ]);

        // 2. On les envoie à la page Home (TRÈS IMPORTANT !)
        return Inertia::render('Home', [
            'projects' => $projects,
        ]);
    }
    public function show(Project $project): Response
    {
        $project->load('tags');

        return Inertia::render('projects/Show', [
            'project' => [
                ...$project->only('title', 'slug', 'summary', 'content', 'demo_url', 'repo_url'),
                'cover_url' => $project->cover_path
                    ? Storage::disk('public')->url($project->cover_path)
                    : null,
                'tags' => $project->tags->pluck('name'),
            ],
        ]);
    }
}
