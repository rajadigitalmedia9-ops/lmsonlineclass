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
    public $upload_type = 'file'; // 'file' or 'url'
    public $video_file;
    public $video_url;
    public $is_free = false;
    
    public function create()
    {
        $this->resetFields();
        $this->showModal = true;
    }
    
    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'upload_type' => 'required|in:file,url',
        ];

        if ($this->upload_type === 'file') {
            $rules['video_file'] = 'required|mimes:mp4,webm|max:51200';
        } else {
            $rules['video_url'] = 'required|url';
        }

        $this->validate($rules);
        
        if ($this->upload_type === 'file') {
            $path = $this->video_file->store('videos', 'r2');
        } else {
            $path = $this->video_url;
        }
        
        Video::create([
            'title' => $this->title,
            'description' => $this->description,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'video_path' => $path,
            'duration' => 0,
            'is_free' => $this->is_free,
            'status' => 'published',
        ]);
        
        $this->showModal = false;
    }
    
    public function delete($id)
    {
        $video = Video::find($id);
        if ($video) {
            if (!str_starts_with($video->video_path, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('r2')->delete($video->video_path);
            }
            $video->delete();
        }
    }
    
    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->course_id = null;
        $this->subject_id = null;
        $this->upload_type = 'file';
        $this->video_file = null;
        $this->video_url = '';
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
