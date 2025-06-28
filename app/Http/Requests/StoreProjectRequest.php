<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'requested_by' => 'required|exists:client_employees,id',
            'project_manager_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source_language' => 'required|string|size:2',
            'target_languages' => 'required|array|min:1',
            'target_languages.*' => 'string|size:2',
            'deadline' => 'required|date',
            'word_count' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'instructions' => 'nullable|string',
        ];
    }
}
