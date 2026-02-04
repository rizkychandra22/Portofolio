<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $username; 
    public $password;

    public function login()
    {
        $this->validate([
            'username' => 'required|min:3',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();
            
            $user = Auth::user();
            session()->flash('info', "Selamat datang kembali {$user->name} 😊");
            
            return $this->redirectIntended(route('user.home'), navigate: true);
        }

        $this->addError('loginError', 'Username atau Password tidak sesuai.');
        $this->reset('password'); 
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar.');
    }
    
    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.login');
    }
}
