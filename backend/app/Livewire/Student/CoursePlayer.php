<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Course Player - Student Portal')]
#[Layout('components.layouts.student')]
class CoursePlayer extends Component
{
    public $course;
    public $activeVideo = null;
    public $activeLiveClass = null;

    public function mount($id)
    {
        $user = auth()->user();
        
        // Verify enrollment
        $enrollment = \App\Models\Enrollment::where('user_id', $user->id)
            ->where('course_id', $id)
            ->firstOrFail();
            
        $this->course = \App\Models\Course::with(['subjects'])->findOrFail($id);
        
        // Check if a specific live class was requested via URL ?live=ID
        if (request()->has('live')) {
            $this->activeLiveClass = \App\Models\LiveClass::where('id', request('live'))
                ->where('course_id', $id)
                ->where('status', 'active')
                ->first();
        }

        // If no live class requested, just load all videos
        // We will pass the videos directly to the view instead of keeping them in memory
    }

    public function selectVideo($videoId)
    {
        $this->activeLiveClass = null;
        $this->activeVideo = \App\Models\Video::findOrFail($videoId);
    }

    public function render()
    {
        // Fetch offline videos for this course
        $videos = \App\Models\Video::where('course_id', $this->course->id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Group them if needed, or just list them
        // For simplicity, we just pass the flat list of videos for this course
            
        return view('livewire.student.course-player', [
            'videos' => $videos
        ]);
    }
}
