<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends BaseController
{
    protected $model = Project::class;
    protected $resource = ProjectResource::class;
    protected $collectionResource = ProjectResource::class;
    protected $rules = [
        'requested_by' => 'required|exists:client_employees,id',
        'project_manager_id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'source_language' => 'required|string|size:2',
        'target_languages' => 'required|array',
        'deadline' => 'required|date',
    ];

    public function index(Request $request)
    {
        $projects = Project::query()
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->client_id, function ($q, $clientId) {
                return $q->whereHas('requester', fn($q) => $q->where('client_id', $clientId));
            })
            ->with(['requester', 'manager'])
            ->paginate(10);

        return ($this->collectionResource)::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $validated['target_languages'] = json_encode($validated['target_languages']);

        $project = Project::create($validated);
        return new $this->resource($project);
    }

    public function show(Project $project)
    {
        return new $this->resource($project->load([
            'requester',
            'manager',
            'files',
            'tasks.assignee',
            'tasks.reviewer'
        ]));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        if (isset($validated['target_languages'])) {
            $validated['target_languages'] = json_encode($validated['target_languages']);
        }

        $project->update($validated);
        return new $this->resource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
