<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEmployeeEmailAlias extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'email',
        'is_verified'
    ];

    public function employee()
    {
        return $this->belongsTo(ClientEmployee::class, 'employee_id');
    }
}
