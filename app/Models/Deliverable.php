<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_id',
        'file_id',
        'delivered_to',
        'delivered_by',
        'delivery_method',
        'read_confirmation',
        'notes'
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function file()
    {
        return $this->belongsTo(ProjectFile::class);
    }

    public function recipient()
    {
        return $this->belongsTo(ClientEmployee::class, 'delivered_to');
    }

    public function deliverer()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }
}
