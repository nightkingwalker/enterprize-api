<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranslationMemoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'source_text' => $this->source_text,
            'target_text' => $this->target_text,
            'source_language' => $this->source_language,
            'target_language' => $this->target_language,
            'project_id' => $this->project_id,
            'client_id' => $this->client_id,
            'domain' => $this->domain,
            'usage_count' => $this->usage_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
