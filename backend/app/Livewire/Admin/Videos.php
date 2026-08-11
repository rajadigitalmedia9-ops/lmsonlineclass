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
    public $video_url;
    public $upload_type = 'file'; // 'file', 'url', or 'manual_r2'
    public $manual_r2_path;
    public $is_free = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'video_file' => 'required_if:upload_type,file|nullable|file|mimes:mp4,mov,avi|max:512000', // 500MB max
            'video_url' => 'required_if:upload_type,url|nullable|url',
            'manual_r2_path' => 'required_if:upload_type,manual_r2|nullable|string',
        ];
    }
    
    public function create()
    {
        $this->resetFields();
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate();

        $path = null;
        $url = null;

        if ($this->upload_type === 'file' && $this->video_file) {
            // Upload directly to Cloudflare R2 disk
            $path = $this->video_file->store('videos', 'r2');
        } elseif ($this->upload_type === 'url') {
            $url = $this->video_url;
        } elseif ($this->upload_type === 'manual_r2') {
            $path = $this->manual_r2_path;
        }

        $video = Video::create([
            'title' => $this->title,
            'description' => $this->description,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'video_path' => $path,
            'video_url' => $url,
            'duration' => 0,
            'is_free' => $this->is_free,
            'status' => 'published',
            'conversion_status' => $path ? 'pending' : 'completed',
        ]);
        
        if ($path) {
            \App\Jobs\ProcessVideoHLS::dispatch($video);
        }
        
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
