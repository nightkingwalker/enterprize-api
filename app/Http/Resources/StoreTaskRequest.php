<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'file_id' => 'required|exists:project_files,id',
            'requested_by' => 'required|exists:client_employees,id',
            'assignee_id' => 'required|exists:users,id',
            'reviewer_id' => 'nullable|exists:users,id',
            'source_language' => 'required|string|size:2',
            'target_language' => 'required|string|size:2',
            'deadline' => 'required|date',
            'priority' => 'sometimes|in:low,medium,high,urgent',
        ];
    }
}
