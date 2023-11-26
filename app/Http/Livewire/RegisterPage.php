<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\AuthController;


class RegisterPage extends Component
{
    public $email;

    public $first_name;
    public $last_name;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'first_name' => 'required|alpha',
        'last_name' => 'required|alpha',
        'email' => 'required|email|unique:users',
        'password' => 'required|same:password_confirmation',
        'password_confirmation' => 'required|same:password',
    ];

    protected $messages = [
        'password.same' => 'The password and confirm password must match.',
        'password_confirmation.same' => 'The password and confirm password must match.',
    ];

    public function render()
    {
        return view('livewire.register-page');
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        // If the updated field is password_confirmation, check if passwords match
        if ($field === 'password_confirmation') {
            $this->validateOnly($field);
            $this->resetErrorBag('password');
        }

    }

}
