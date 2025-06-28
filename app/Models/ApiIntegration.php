<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'credentials',
        'status',
        'last_used_at'
    ];

    protected $casts = [
        'credentials' => 'array',
        'last_used_at' => 'datetime',
    ];

    // Relationships
    public function emailRules()
    {
        return $this->hasMany(EmailProcessingRule::class, 'integration_id');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }
}
