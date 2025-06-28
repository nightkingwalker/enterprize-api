<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectFileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'original_name' => $this->original_name,
            'file_type' => $this->file_type,
            'word_count' => $this->word_count,
            'pages' => $this->pages,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'download_url' => route('api.project-files.download', $this->id),
        ];
    }
}
