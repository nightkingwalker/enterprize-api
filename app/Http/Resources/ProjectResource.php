<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'requested_by' => $this->requested_by,
            'project_manager_id' => $this->project_manager_id,
            'name' => $this->name,
            'description' => $this->description,
            'source_language' => $this->source_language,
            'target_languages' => $this->target_languages,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'word_count' => $this->word_count,
            'price' => $this->price,
            'currency' => $this->currency,
            'instructions' => $this->instructions,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'requester' => new ClientEmployeeResource($this->whenLoaded('requester')),
            'manager' => new UserResource($this->whenLoaded('manager')),
            'files' => ProjectFileResource::collection($this->whenLoaded('files')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
