<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'requested_by' => 'sometimes|exists:client_employees,id',
            'project_manager_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'source_language' => 'sometimes|string|size:2',
            'target_languages' => 'sometimes|array|min:1',
            'target_languages.*' => 'string|size:2',
            'deadline' => 'sometimes|date',
            'status' => 'sometimes|in:pending,in_progress,review,completed,delivered,archived',
            'word_count' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'instructions' => 'nullable|string',
        ];
    }
}
