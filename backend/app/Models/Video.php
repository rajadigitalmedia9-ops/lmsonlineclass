<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['live_class_id', 'title', 'storage_key', 'duration', 'processing_status', 'status'];

    public function liveClass()
    {
        return $this->belongsTo(LiveClass::class);
    }

    public function watchHistories()
    {
        return $this->hasMany(VideoWatchHistory::class);
    }
}
