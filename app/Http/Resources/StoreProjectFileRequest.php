<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'file' => 'required|file|mimes:docx,pdf,txt,xlsx,pptx,html,json,xml|max:10240',
        ];
    }
}
