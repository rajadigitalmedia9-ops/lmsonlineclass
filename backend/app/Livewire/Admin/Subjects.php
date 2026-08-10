<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Subject;
use App\Models\Course;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Subjects - Admin')]
#[Layout('components.layouts.app')]
class Subjects extends Component
{
    public $showModal = false;
    public $isEdit = false;
    
    // Form fields
    public $subject_id;
    public $name;
    public $course_id;

    public function create()
    {
        $this->resetValidation();
        $this->reset(['subject_id', 'name', 'course_id']);
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $subject = Subject::findOrFail($id);
        $this->subject_id = $subject->id;
        $this->name = $subject->name;
        $this->course_id = $subject->course_id;
        
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($this->isEdit) {
            $subject = Subject::findOrFail($this->subject_id);
            $subject->update([
                'name' => $this->name,
                'course_id' => $this->course_id,
            ]);
        } else {
            Subject::create([
                'name' => $this->name,
                'course_id' => $this->course_id,
            ]);
        }

        $this->showModal = false;
        $this->reset(['subject_id', 'name', 'course_id']);
    }

    public function delete($id)
    {
        Subject::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.subjects', [
            'subjects' => Subject::with('course')->latest()->get(),
            'courses' => Course::all(),
        ]);
    }
}
