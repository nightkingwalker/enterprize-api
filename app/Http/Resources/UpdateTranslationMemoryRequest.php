<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationMemoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'source_text' => 'sometimes|string',
            'target_text' => 'sometimes|string',
            'domain' => 'nullable|string|max:100',
        ];
    }
}
