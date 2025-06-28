<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'user_id',
        'comment',
        'resolved'
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
