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

    public function getStreamUrlAttribute()
    {
        if (!empty($this->hls_path) && $this->conversion_status === 'completed') {
            return \Illuminate\Support\Facades\Storage::disk('r2')->temporaryUrl($this->hls_path, now()->addHours(3));
        }

        if (empty($this->video_path)) {
            return null;
        }

        if (str_starts_with($this->video_path, 'http')) {
            return $this->video_path;
        }

        try {
            return \Illuminate\Support\Facades\Storage::disk('r2')
                ->temporaryUrl($this->video_path, now()->addHours(3));
        } catch (\Exception $e) {
            return null;
        }
    }
}
