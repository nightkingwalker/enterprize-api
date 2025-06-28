<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'billing_address' => $this->billing_address,
            'tax_id' => $this->tax_id,
            'payment_terms' => $this->payment_terms,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employees' => ClientEmployeeResource::collection($this->whenLoaded('employees')),
            'domains' => $this->whenLoaded('domains'),
        ];
    }
}
