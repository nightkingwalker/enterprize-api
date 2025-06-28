<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliverableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'sometimes|exists:projects,id',
            'file_id' => 'sometimes|exists:project_files,id',
            'delivered_to' => 'sometimes|exists:client_employees,id',
            'delivery_method' => 'sometimes|in:email,platform,whatsapp,ftp,other',
            'read_confirmation' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ];
    }
}
