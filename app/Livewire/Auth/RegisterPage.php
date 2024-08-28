<?php

namespace App\Livewire\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function save(){
        // dd($this->name,$this->email,$this->password);
        $this->validate([
            'name'=>'required|max:255',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|min:6|max:255',
        ]);
        //save to db
        $user=User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>Hash::make($this->password),
        ]);

        //login
        auth()->login($user);

        //redirect to home page
        return redirect()->intended();

    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
