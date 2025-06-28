<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationMemoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'source_text' => 'required|string',
            'target_text' => 'required|string',
            'source_language' => 'required|string|size:2',
            'target_language' => 'required|string|size:2',
            'project_id' => 'nullable|exists:projects,id',
            'client_id' => 'nullable|exists:clients,id',
            'domain' => 'nullable|string|max:100',
        ];
    }
}
