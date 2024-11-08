<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title("Register")]
class RegisterPage extends Component
{

    public $name;
    public $email;
    public $password;

    public function save()
    {
        $this->validate([
            "name" => "required",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|min:6"
        ]);

        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => Hash::make($this->password)
        ]);

        auth()->login($user);
        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
