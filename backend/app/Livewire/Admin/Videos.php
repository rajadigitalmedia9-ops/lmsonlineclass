<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Video;
use App\Models\Course;
use App\Models\Subject;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Videos - Admin')]
#[Layout('components.layouts.app')]
class Videos extends Component
{
    use WithFileUploads;

    public $showModal = false;
    
    // Form fields
    public $title;
    public $description;
    public $course_id;
    public $subject_id;
    public $video_file;
    public $is_free = false;
    
    public function create()
    {
        $this->resetFields();
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'video_file' => 'required|mimes:mp4,webm|max:51200', // max 50MB for Render testing
        ]);
        
        // Store video in private disk
        $path = $this->video_file->store('videos', 'local');
        
        Video::create([
            'title' => $this->title,
            'description' => $this->description,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'video_path' => $path,
            'duration' => 0, // In reality, we'd extract this with FFMPEG
            'is_free' => $this->is_free,
            'status' => 'published',
        ]);
        
        $this->showModal = false;
    }
    
    public function delete($id)
    {
        $video = Video::find($id);
        if ($video) {
            \Illuminate\Support\Facades\Storage::disk('local')->delete($video->video_path);
            $video->delete();
        }
    }
    
    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->course_id = null;
        $this->subject_id = null;
        $this->video_file = null;
        $this->is_free = false;
    }

    public function render()
    {
        return view('livewire.admin.videos', [
            'videos' => Video::with(['course', 'subject'])->orderBy('created_at', 'desc')->get(),
            'courses' => Course::all(),
            'subjects' => Subject::all(),
        ]);
    }
}
