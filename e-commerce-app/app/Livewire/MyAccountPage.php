<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My account')]
class MyAccountPage extends Component
{
    public $name;
    public $email;
    public $currentPassword;
    public $password;
    public $password_confirmation;
    public $isEditing = false;
    protected $originalName;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->originalName = $this->name;
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.my-account', [
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function updateName()
    {
        $this->validate([
            'name' => 'required|min:2|max:255',
        ]);

        try {
            $user = Auth::user();
            $user->name = $this->name;
            $user->save();

            $this->originalName = $this->name;
            $this->isEditing = false;

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Name updated successfully.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Failed to update name. Please try again.'
            ]);
        }
    }

    public function update()
    {
        $this->validate([
            'currentPassword' => 'required|current_password',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $user = Auth::user();

            $user->password = Hash::make($this->password);
            $user->save();

            $this->reset(['currentPassword', 'password', 'password_confirmation']);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Password changed successfully.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Failed to update password. Please try again.'
            ]);
        }
    }

    public function toggleEdit()
    {
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->name = $this->originalName;
    }
}
