<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Students - Admin')]
#[Layout('components.layouts.app')]
class Students extends Component
{
    public $showModal = false;
    public $isEdit = false;
    
    // Form fields
    public $student_id;
    public $name;
    public $email;
    public $mobile;
    public $password;
    
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
        
        $student = User::find($id);
        $this->student_id = $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->mobile = $student->mobile;
        
        $this->showModal = true;
    }
    
    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->isEdit ? $this->student_id : 'NULL'),
            'mobile' => 'nullable|string|max:20|unique:users,mobile,' . ($this->isEdit ? $this->student_id : 'NULL'),
        ];
        
        if (!$this->isEdit) {
            $rules['password'] = 'required|min:6';
        }
        
        $this->validate($rules);
        
        if ($this->isEdit) {
            $student = User::find($this->student_id);
            $student->name = $this->name;
            $student->email = $this->email;
            $student->mobile = $this->mobile;
            if ($this->password) {
                $student->password = Hash::make($this->password);
            }
            $student->save();
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'password' => Hash::make($this->password),
            ]);
        }
        
        $this->showModal = false;
    }
    
    public function delete($id)
    {
        User::destroy($id);
    }
    
    public function resetFields()
    {
        $this->student_id = null;
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->password = '';
    }

    // Enrollment Properties
    public $showEnrollmentModal = false;
    public $managingStudentId;
    public $selectedCourses = [];
    public $allCourses = [];

    public function mount()
    {
        $this->allCourses = \App\Models\Course::where('status', 'active')->get();
    }

    public function render()
    {
        $students = User::where('email', '!=', 'admin@artinlms.com')
            ->with('enrollments.course')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('livewire.admin.students', [
            'students' => $students
        ]);
    }

    public function manageEnrollments($id)
    {
        $this->managingStudentId = $id;
        $student = User::with('enrollments')->findOrFail($id);
        $this->selectedCourses = $student->enrollments->pluck('course_id')->toArray();
        $this->showEnrollmentModal = true;
    }

    public function saveEnrollments()
    {
        $student = User::findOrFail($this->managingStudentId);
        
        \App\Models\Enrollment::where('user_id', $student->id)->delete();
        
        foreach ($this->selectedCourses as $courseId) {
            \App\Models\Enrollment::create([
                'user_id' => $student->id,
                'course_id' => $courseId,
                'batch_id' => \App\Models\Batch::where('course_id', $courseId)->value('id') ?? 1,
                'status' => 'active',
                'start_date' => now(),
            ]);
        }
        
        $this->showEnrollmentModal = false;
    }
}
