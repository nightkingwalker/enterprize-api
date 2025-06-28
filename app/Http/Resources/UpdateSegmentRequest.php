<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSegmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'translated_text' => 'nullable|string',
            'status' => 'sometimes|in:not_started,in_progress,translated,reviewed,approved',
            'is_repeated' => 'sometimes|boolean',
            'repeat_of' => 'nullable|exists:segments,id',
        ];
    }
}
