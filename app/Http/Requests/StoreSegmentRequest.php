<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSegmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'original_text' => 'required|string',
            'segment_number' => 'required|integer|min:1',
            'is_repeated' => 'sometimes|boolean',
            'repeat_of' => 'nullable|exists:segments,id',
        ];
    }
}
