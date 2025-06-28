<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'sometimes|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('client_employees')->ignore($this->client_employee)
            ],
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'is_primary_contact' => 'sometimes|boolean',
            'can_receive_deliverables' => 'sometimes|boolean',
            'notification_preferences' => 'nullable|array',
            'notification_preferences.*' => 'string|in:email,whatsapp,sms',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('notification_preferences') && is_string($this->notification_preferences)) {
            $this->merge([
                'notification_preferences' => json_decode($this->notification_preferences, true)
            ]);
        }
    }
}
