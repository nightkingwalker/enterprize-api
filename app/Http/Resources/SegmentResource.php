<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SegmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'original_text' => $this->original_text,
            'translated_text' => $this->translated_text,
            'segment_number' => $this->segment_number,
            'status' => $this->status,
            'word_count' => $this->word_count,
            'char_count' => $this->char_count,
            'is_repeated' => $this->is_repeated,
            'repeat_of' => $this->repeat_of,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'history' => SegmentHistoryResource::collection($this->whenLoaded('history')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
