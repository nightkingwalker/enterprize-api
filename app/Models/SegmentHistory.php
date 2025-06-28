<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'user_id',
        'action',
        'content_before',
        'content_after'
    ];

    // Relationships
    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
