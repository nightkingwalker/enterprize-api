<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'sometimes|exists:projects,id',
            'status' => 'sometimes|in:uploaded,processing,ready,error',
            'word_count' => 'sometimes|integer|min:0',
            'pages' => 'nullable|integer|min:1',
        ];
    }
}
