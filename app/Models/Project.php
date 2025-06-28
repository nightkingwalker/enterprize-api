<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'requested_by',
        'project_manager_id',
        'name',
        'description',
        'source_language',
        'target_languages',
        'deadline',
        'status',
        'word_count',
        'price',
        'currency',
        'instructions'
    ];

    protected $casts = [
        'target_languages' => 'array',
        'deadline' => 'datetime',
    ];

    // Relationships
    public function requester()
    {
        return $this->belongsTo(ClientEmployee::class, 'requested_by');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    public function translationMemories()
    {
        return $this->hasMany(TranslationMemory::class);
    }

    public function glossaryTerms()
    {
        return $this->hasMany(GlossaryTerm::class);
    }

    // Helper method to get client through requester
    public function client()
    {
        return $this->requester->client;
    }
}
