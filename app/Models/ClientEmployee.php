<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'email',
        'phone',
        'department',
        'position',
        'is_primary_contact',
        'can_receive_deliverables',
        'notification_preferences'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailAliases()
    {
        return $this->hasMany(ClientEmployeeEmailAlias::class, 'employee_id');
    }

    public function requestedProjects()
    {
        return $this->hasMany(Project::class, 'requested_by');
    }

    public function requestedTasks()
    {
        return $this->hasMany(Task::class, 'requested_by');
    }

    public function deliveries()
    {
        return $this->hasMany(Deliverable::class, 'delivered_to');
    }
}
