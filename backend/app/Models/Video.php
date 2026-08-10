<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_class_id', 'course_id', 'subject_id', 
        'title', 'description', 'video_path', 'storage_key', 
        'duration', 'processing_status', 'status', 'is_free'
    ];

    public function liveClass()
    {
        return $this->belongsTo(LiveClass::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function watchHistories()
    {
        return $this->hasMany(VideoWatchHistory::class);
    }
}
