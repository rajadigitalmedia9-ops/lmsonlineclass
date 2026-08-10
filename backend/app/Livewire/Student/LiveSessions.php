<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Live Sessions - Student Portal')]
#[Layout('components.layouts.student')]
class LiveSessions extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Find all courses the user is enrolled in
        $enrolledCourseIds = \App\Models\Enrollment::where('user_id', $user->id)
            ->pluck('course_id');
            
        // Find active and scheduled live classes for these courses
        $liveClasses = \App\Models\LiveClass::whereIn('course_id', $enrolledCourseIds)
            ->whereIn('status', ['active', 'scheduled'])
            ->with(['course', 'subject', 'batch'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('livewire.student.live-sessions', [
            'liveClasses' => $liveClasses
        ]);
    }
}
