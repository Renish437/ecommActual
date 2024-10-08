<?php


namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function save()
    {
        // Validate the input
        $this->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        // Attempt to authenticate
        if (!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            // Flash a single error message to the session
            session()->flash('error', 'Invalid Credentials');
            return;
        }

        // Redirect to the intended URL after successful login
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}

// namespace App\Livewire\Auth;

// use Livewire\Component;
// use Livewire\Attributes\Title;
// #[Title('Login')]
// class LoginPage extends Component
// {
//     public $email;
//     public $password;

//     public function save(){
//         $this->validate([
//             'email'=>'required|email|max:255',
//             'password'=>'required|min:6|max:255',
//         ]);

//         if(!auth()->attempt(['email'=>$this->email,'password'=>$this->password])){
//             session()->flash('error','Invalid Credentials');
//             return;
           
//         }
//         return redirect()->intended();
//     }


//     public function render()
//     {
//         return view('livewire.auth.login-page');
//     }
// }
