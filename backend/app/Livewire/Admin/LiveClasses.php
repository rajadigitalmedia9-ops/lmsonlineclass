<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LiveClass;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Subject;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Live Classes - Admin')]
#[Layout('components.layouts.app')]
class LiveClasses extends Component
{
    public $liveClasses;
    public $courses;
    public $batches;
    public $subjects;

    public $showModal = false;
    public $isEdit = false;
    
    // Form fields
    public $class_id;
    public $course_id;
    public $batch_id;
    public $subject_id;
    public $title;
    public $scheduled_at;
    public $duration = 60;
    
    // Custom OBS fields
    public $live_room_id; // Acts as stream key
    
    public function mount()
    {
        $this->loadData();
        $this->courses = Course::all();
        $this->batches = Batch::all();
        $this->subjects = Subject::all();
    }
    
    public function loadData()
    {
        $this->liveClasses = LiveClass::with(['course', 'batch', 'subject'])->orderBy('scheduled_at', 'desc')->get();
    }
    
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
        
        $liveClass = LiveClass::find($id);
        $this->class_id = $liveClass->id;
        $this->course_id = $liveClass->course_id;
        $this->batch_id = $liveClass->batch_id;
        $this->subject_id = $liveClass->subject_id;
        $this->title = $liveClass->title;
        $this->scheduled_at = \Carbon\Carbon::parse($liveClass->scheduled_at)->format('Y-m-d\TH:i');
        $this->duration = $liveClass->duration;
        $this->live_room_id = $liveClass->live_room_id;
        
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'subject_id' => 'required|exists:subjects,id',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);
        
        if ($this->isEdit) {
            $liveClass = LiveClass::find($this->class_id);
            $liveClass->update([
                'title' => $this->title,
                'course_id' => $this->course_id,
                'batch_id' => $this->batch_id,
                'subject_id' => $this->subject_id,
                'scheduled_at' => $this->scheduled_at,
                'duration' => $this->duration,
            ]);
        } else {
            LiveClass::create([
                'title' => $this->title,
                'course_id' => $this->course_id,
                'batch_id' => $this->batch_id,
                'subject_id' => $this->subject_id,
                'scheduled_at' => $this->scheduled_at,
                'duration' => $this->duration,
                'status' => 'scheduled',
            ]);
        }
        
        $this->showModal = false;
        $this->loadData();
    }
    
    public function startClass($id)
    {
        $liveClass = LiveClass::find($id);
        // Generate a random string as the Stream Key for OBS
        $liveClass->live_room_id = \Illuminate\Support\Str::random(20);
        $liveClass->status = 'active';
        $liveClass->save();
        
        $this->loadData();
    }
    
    public function endClass($id)
    {
        $liveClass = LiveClass::find($id);
        $liveClass->status = 'completed';
        $liveClass->save();
        
        $this->loadData();
    }
    
    public function delete($id)
    {
        LiveClass::destroy($id);
        $this->loadData();
    }
    
    public function resetFields()
    {
        $this->class_id = null;
        $this->course_id = null;
        $this->batch_id = null;
        $this->subject_id = null;
        $this->title = '';
        $this->scheduled_at = '';
        $this->duration = 60;
        $this->live_room_id = null;
    }

    public function render()
    {
        return view('livewire.admin.live-classes');
    }
}
