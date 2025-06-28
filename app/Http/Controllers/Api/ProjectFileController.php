<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectFile;
use App\Http\Resources\ProjectFileResource;
use App\Http\Requests\StoreProjectFileRequest;
use App\Http\Requests\UpdateProjectFileRequest;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends BaseController
{
    protected $model = ProjectFile::class;
    protected $resource = ProjectFileResource::class;
    protected $collectionResource = ProjectFileResource::class;
    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'file' => 'required|file|mimes:docx,pdf,txt,xlsx,pptx|max:10240',
    ];

    public function index(Request $request)
    {
        $files = ProjectFile::query()
            ->when($request->project_id, fn($q, $projectId) => $q->where('project_id', $projectId))
            ->paginate(10);

        return ($this->collectionResource)::collection($files);
    }

    public function store(StoreProjectFileRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store('project_files');

        $projectFile = ProjectFile::create([
            'project_id' => $request->project_id,
            'original_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'uploaded_by' => auth()->id(),
        ]);

        return new $this->resource($projectFile);
    }

    public function show(ProjectFile $file)
    {
        return new $this->resource($file);
    }

    public function update(UpdateProjectFileRequest $request, ProjectFile $file)
    {
        $file->update($request->validated());
        return new $this->resource($file);
    }

    public function destroy(ProjectFile $file)
    {
        Storage::delete($file->storage_path);
        $file->delete();
        return response()->json(['message' => 'File deleted successfully']);
    }
}