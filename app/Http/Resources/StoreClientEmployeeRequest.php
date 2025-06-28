<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:client_employees,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'is_primary_contact' => 'sometimes|boolean',
            'can_receive_deliverables' => 'sometimes|boolean',
            'notification_preferences' => 'nullable|array',
            'notification_preferences.*' => 'string|in:email,whatsapp,sms',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already associated with another employee',
            'notification_preferences.*.in' => 'Invalid notification channel',
        ];
    }
}
