<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\Video;
use Livewire\Attributes\Title;

#[Title('Admin Dashboard')]
class Dashboard extends Component
{
    public $studentCount = 0;
    public $courseCount = 0;
    public $liveClassCount = 0;
    public $videoCount = 0;
    
    public function mount()
    {
        $this->studentCount = User::count();
        $this->courseCount = Course::count();
        $this->liveClassCount = LiveClass::count();
        $this->videoCount = Video::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
