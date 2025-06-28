<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assignee_id' => 'sometimes|exists:users,id',
            'reviewer_id' => 'nullable|exists:users,id',
            'status' => 'sometimes|in:not_started,in_progress,submitted,in_review,completed,rejected',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'deadline' => 'sometimes|date',
            'completed_at' => 'nullable|date',
        ];
    }
}
