<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailProcessingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'subject_pattern',
        'sender_pattern',
        'action',
        'project_template_id',
        'notification_recipients',
        'is_active'
    ];

    protected $casts = [
        'notification_recipients' => 'array',
    ];

    // Relationships
    public function integration()
    {
        return $this->belongsTo(ApiIntegration::class, 'integration_id');
    }

    public function projectTemplate()
    {
        return $this->belongsTo(Project::class, 'project_template_id');
    }
}
