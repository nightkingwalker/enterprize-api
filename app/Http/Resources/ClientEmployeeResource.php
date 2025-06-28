<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientEmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'department' => $this->department,
            'position' => $this->position,
            'is_primary_contact' => $this->is_primary_contact,
            'can_receive_deliverables' => $this->can_receive_deliverables,
            'notification_preferences' => $this->notification_preferences,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'email_aliases' => $this->whenLoaded('emailAliases'),
        ];
    }
}
