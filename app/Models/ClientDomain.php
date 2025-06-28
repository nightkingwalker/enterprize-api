<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'domain',
        'is_primary'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
