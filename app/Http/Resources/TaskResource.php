<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'file_id' => $this->file_id,
            'requested_by' => $this->requested_by,
            'assignee_id' => $this->assignee_id,
            'reviewer_id' => $this->reviewer_id,
            'source_language' => $this->source_language,
            'target_language' => $this->target_language,
            'segment_count' => $this->segment_count,
            'word_count' => $this->word_count,
            'status' => $this->status,
            'priority' => $this->priority,
            'deadline' => $this->deadline,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'file' => new ProjectFileResource($this->whenLoaded('file')),
            'assignee' => new UserResource($this->whenLoaded('assignee')),
            'reviewer' => new UserResource($this->whenLoaded('reviewer')),
            'segments' => SegmentResource::collection($this->whenLoaded('segments')),
        ];
    }
}
