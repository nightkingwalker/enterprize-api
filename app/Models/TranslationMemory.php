<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationMemory extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_text',
        'target_text',
        'source_language',
        'target_language',
        'project_id',
        'client_id',
        'domain',
        'usage_count'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
