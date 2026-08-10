<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('My Courses - Student Portal')]
#[Layout('components.layouts.student')]
class MyCourses extends Component
{
    public $search = '';
    public $filter = 'all'; // all, in_progress, completed, not_started

    public function render()
    {
        $user = auth()->user();
        
        // Fetch enrollments with course details
        $query = \App\Models\Enrollment::where('user_id', $user->id)
            ->with(['course.subjects.chapters.lessons', 'batch'])
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('enrollments.*');
            
        if ($this->search) {
            $query->where('courses.name', 'like', '%' . $this->search . '%');
        }
        
        $enrollments = $query->get();

        return view('livewire.student.my-courses', [
            'enrollments' => $enrollments
        ]);
    }
}
