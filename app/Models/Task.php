<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'file_id',
        'requested_by',
        'assignee_id',
        'reviewer_id',
        'source_language',
        'target_language',
        'segment_count',
        'word_count',
        'status',
        'priority',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function file()
    {
        return $this->belongsTo(ProjectFile::class, 'file_id');
    }

    public function requester()
    {
        return $this->belongsTo(ClientEmployee::class, 'requested_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function segments()
    {
        return $this->hasMany(Segment::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    // Status check helpers
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }
}
