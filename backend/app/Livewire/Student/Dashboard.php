<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Student Dashboard')]
#[Layout('components.layouts.student')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Fetch enrollments to calculate basic stats
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)
            ->with('course')
            ->get();
            
        $totalCourses = $enrollments->count();
        // Dummy stats for now to match the UI requested
        $lessonsDone = 0; 
        $certificates = 0;
        $learningHours = 0;

        return view('livewire.student.dashboard', [
            'totalCourses' => $totalCourses,
            'lessonsDone' => $lessonsDone,
            'certificates' => $certificates,
            'learningHours' => $learningHours,
        ]);
    }
}
