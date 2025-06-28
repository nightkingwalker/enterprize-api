<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'original_text',
        'translated_text',
        'segment_number',
        'status',
        'word_count',
        'char_count',
        'is_repeated',
        'repeat_of'
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function history()
    {
        return $this->hasMany(SegmentHistory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function originalSegment()
    {
        return $this->belongsTo(Segment::class, 'repeat_of');
    }

    public function repeatedSegments()
    {
        return $this->hasMany(Segment::class, 'repeat_of');
    }

    // Status check helpers
    public function isTranslated()
    {
        return $this->status === 'translated';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
