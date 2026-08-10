<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Enforce 1 active device per user (Invalidates other sessions)
            Auth::logoutOtherDevices($this->password);
            
            session()->regenerate();
            
            // Check for admin, redirect to admin dashboard
            if ($this->email === 'admin@artinlms.com') {
                return redirect()->intended('/admin/dashboard');
            }

            // Normal student login
            return redirect()->intended('/student/dashboard');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.student.login');
    }
}
