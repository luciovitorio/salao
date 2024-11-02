<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;


class Login extends Component
{
    use Interactions;

    #[Validate('required', message: 'O campo nome de usuário é obrigatório.')]
    public $username;

    #[Validate('required', message: 'O campo senha é obrigatório.')]
    public $password;

    #[Title('Login')]
    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'username' => $this->username,
            'password' => $this->password
        ])) {
            if (Auth::user()->role === 'Administrador') {
                session()->regenerate();

                return $this->redirect('/dashboard');
            } else {
                Auth::logout();
                $this->toast()->error('Você não tem permissão para acessar essa área.')->send();
            }
        } else {
            $this->toast()->error('Usuário e/ou senha inválidos.')->send();
        }
    }
}
