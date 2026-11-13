<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\ProjectRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::orderBy('position')
            ->get()
            ->map(fn(Project $project) => [
                ...$project->only('id', 'title', 'slug', 'position', 'published_at'),
            ]);

        return Inertia::render('admin/projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/projects/Create', [
            'tags' => Tag::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['tags', 'cover']);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('projects', 'public');
        }

        $project = Project::create([
            ...$data,
            'position' => Project::max('position') + 1,
        ]);

        $project->tags()->sync($request->validated('tags', []));

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Projet créé.']);

        return to_route('admin.projects.index');
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('admin/projects/Edit', [
            'project' => array_merge(
                $project->only('id', 'title', 'summary', 'content', 'demo_url', 'repo_url', 'cover_url'),
                ['tags' => $project->tags()->pluck('tags.id')]
            ),
            'tags' => Tag::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->safe()->except(['tags', 'cover']);

        if ($request->hasFile('cover')) {
            // On supprime l'ancienne image SEULEMENT si elle est dans le dossier "projects/"
            if ($project->cover_path && str_starts_with($project->cover_path, 'projects/')) {
                Storage::disk('public')->delete($project->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('projects', 'public');
        }

        $project->update($data);
        $project->tags()->sync($request->validated('tags', []));

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Projet modifié.']);

        return to_route('admin.projects.index');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->cover_path && str_starts_with($project->cover_path, 'projects/')) {
            Storage::disk('public')->delete($project->cover_path);
        }

        $project->delete();

        // On prépare la petite notification de succès
        Inertia::flash('toast', ['type' => 'success', 'message' => 'Projet supprimé.']);

        // On redirige vers la liste, qui sera rechargée sans ce projet
        return to_route('admin.projects.index');
    }

    public function togglePublished(Project $project): RedirectResponse
    {
        $project->update([
            'published_at' => $project->published_at ? null : now(),
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $project->published_at ? 'Projet publié.' : 'Projet repassé en brouillon.',
        ]);

        return to_route('admin.projects.index');
    }

    public function moveUp(Project $project): RedirectResponse
    {
        // On cherche le voisin du dessus (position plus petite, mais la plus grande d'entre elles)
        $previous = Project::where('position', '<', $project->position)
            ->orderByDesc('position')
            ->first();

        if ($previous) {
            $this->swapPositions($project, $previous);
        }

        return to_route('admin.projects.index');
    }

    public function moveDown(Project $project): RedirectResponse
    {
        // On cherche le voisin du dessous (position plus grande, la première qu'on trouve)
        $next = Project::where('position', '>', $project->position)
            ->orderBy('position')
            ->first();

        if ($next) {
            $this->swapPositions($project, $next);
        }

        return to_route('admin.projects.index');
    }

    private function swapPositions(Project $first, Project $second): void
    {
        // Échange magique en une seule ligne
        [$first->position, $second->position] = [$second->position, $first->position];

        $first->save();
        $second->save();
    }
}
