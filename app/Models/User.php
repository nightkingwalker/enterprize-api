<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'language_pairs',
        'hourly_rate'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'language_pairs' => 'array',
    ];

    // Relationships
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function clientEmployee()
    {
        return $this->hasOne(ClientEmployee::class);
    }

    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    public function reviewTasks()
    {
        return $this->hasMany(Task::class, 'reviewer_id');
    }

    public function uploadedFiles()
    {
        return $this->hasMany(ProjectFile::class, 'uploaded_by');
    }

    public function deliveries()
    {
        return $this->hasMany(Deliverable::class, 'delivered_by');
    }

    public function segmentHistory()
    {
        return $this->hasMany(SegmentHistory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
