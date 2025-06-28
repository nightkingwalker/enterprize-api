<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliverableResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'task_id' => $this->task_id,
            'file_id' => $this->file_id,
            'delivered_to' => $this->delivered_to,
            'delivered_by' => $this->delivered_by,
            'delivery_method' => $this->delivery_method,
            'delivery_date' => $this->delivery_date,
            'read_confirmation' => $this->read_confirmation,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'task' => new TaskResource($this->whenLoaded('task')),
            'file' => new ProjectFileResource($this->whenLoaded('file')),
            'recipient' => new ClientEmployeeResource($this->whenLoaded('recipient')),
            'deliverer' => new UserResource($this->whenLoaded('deliverer')),
        ];
    }
}
