<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends BaseController
{
    protected $model = Task::class;
    protected $resource = TaskResource::class;
    protected $collectionResource = TaskResource::class;
    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'file_id' => 'required|exists:project_files,id',
        'requested_by' => 'required|exists:client_employees,id',
        'assignee_id' => 'required|exists:users,id',
        'source_language' => 'required|string|size:2',
        'target_language' => 'required|string|size:2',
        'deadline' => 'required|date',
    ];

    public function index(Request $request)
    {
        $tasks = Task::query()
            ->when($request->project_id, fn($q, $projectId) => $q->where('project_id', $projectId))
            ->when($request->assignee_id, fn($q, $assigneeId) => $q->where('assignee_id', $assigneeId))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->with(['project', 'file', 'assignee', 'reviewer'])
            ->paginate(10);

        return ($this->collectionResource)::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return new $this->resource($task);
    }

    public function show(Task $task)
    {
        return new $this->resource($task->load([
            'project',
            'file',
            'assignee',
            'reviewer',
            'segments'
        ]));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return new $this->resource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
