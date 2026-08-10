<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Courses - Admin')]
#[Layout('components.layouts.app')]
class Courses extends Component
{
    public $showModal = false;
    public $isEdit = false;
    
    // Form fields
    public $course_id;
    public $name;
    public $description;
    public $status = 'active';
    
    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->showModal = true;
    }
    
    public function edit($id)
    {
        $this->resetFields();
        $this->isEdit = true;
        
        $course = Course::find($id);
        $this->course_id = $course->id;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->status = $course->status;
        
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        
        if ($this->isEdit) {
            $course = Course::find($this->course_id);
            $course->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
            ]);
        } else {
            Course::create([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
            ]);
        }
        
        $this->showModal = false;
    }
    
    public function delete($id)
    {
        Course::destroy($id);
    }
    
    public function resetFields()
    {
        $this->course_id = null;
        $this->name = '';
        $this->description = '';
        $this->status = 'active';
    }

    public function render()
    {
        $courses = Course::withCount(['batches', 'subjects'])->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.courses', [
            'courses' => $courses
        ]);
    }
}
