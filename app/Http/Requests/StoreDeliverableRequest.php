<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliverableRequest extends FormRequest
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
            'delivered_to' => 'required|exists:client_employees,id',
            'delivery_method' => 'required|in:email,platform,whatsapp,ftp,other',
            'notes' => 'nullable|string',
        ];
    }
}
