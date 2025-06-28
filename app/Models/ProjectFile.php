<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'original_name',
        'storage_path',
        'file_type',
        'word_count',
        'pages',
        'uploaded_by',
        'status'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'file_id');
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }
}
