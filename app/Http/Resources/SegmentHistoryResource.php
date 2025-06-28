<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SegmentHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'segment_id' => $this->segment_id,
            'user_id' => $this->user_id,
            'action' => $this->action,
            'content_before' => $this->content_before,
            'content_after' => $this->content_after,
            'created_at' => $this->created_at,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
