<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $form = [
        'email' => '',
        'password' => '',
        'remember' => false,
    ];

    public function login()
    {
        if (Auth::attempt([
            'email' => $this->form['email'],
            'password' => $this->form['password']
        ], $this->form['remember'])) {
            
            session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        $this->addError('form.email', 'Email atau Password salah.');
    }

    public function render()
    {
        return view('livewire.pages.auth.login')
            ->layout('layouts.guest');
    }
}
