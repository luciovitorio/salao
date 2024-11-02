<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Criação de usuário')]
class UserCreateComponent extends Component
{
    use Interactions;

    // protected $listeners = ['editUser'];

    public $userId;
    public $name;
    public $username;
    public $email;
    public $role;
    public $password;
    public $confirm_password;
    public $commission;
    public $type;

    public function mount($user = null)
    {
        if ($user) {
            $user = User::findOrFail($user);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->commission = $user->commission;
            $this->type = 'edição';
        } else {
            $user = null;
            $this->type = 'criação';
        }
    }

    public function render()
    {
        return view('livewire.user.user-create-component');
    }

    public function create()
    {
        $rules = [
            'role' => 'required|in:Administrador,Funcionário',
            'name' => 'required|min:3',
            'username' => $this->role === 'Administrador' ? 'required|min:3|regex:/^\S*$/u|unique:users' : 'nullable',
            'email' => 'nullable|email',
            'password' => $this->role === 'Administrador' ? 'required|min:3' : 'nullable',
            'confirm_password' => $this->role === 'Administrador' ? 'required|same:password|min:3' : 'nullable',
            'commission' => 'nullable|integer|numeric'
        ];

        $messages = [
            'role.required' => 'O campo perfil é obrigatório',
            'role.in' => 'O campo perfil tem um valor inválido',
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome precisa ter no mínimo 3 caracteres.',
            'username.required' => 'O campo nome de usuário é obrigatório para administradores.',
            'username.unique' => 'Já existe um usuario com esse nome.',
            'username.regex' => 'O nome de usuário não pode ter espaços.',
            'password.required' => 'O campo senha é obrigatório para administradores.',
            'password.min' => 'A senha precisa ter no mínimo 3 caracteres.',
            'confirm_password.required' => 'O campo de confirmação de senha é obrigatório para administradores.',
            'confirm_password.same' => 'A confirmação da senha precisa coincidir com a senha.',
            'commission.integer' => 'O campo comissão deve ser um numero inteiro',
            'commission.numeric' => 'O campo comissão deve ser um número.'
        ];

        $this->validate($rules, $messages);

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role === 'Administrador' ? 'admin' : 'func',
            'commission' => $this->commission ? $this->commission : 0
        ]);

        $this->reset(['name', 'username', 'email', 'password', 'role', 'confirm_password', 'commission']);
        return $this->toast()->success('Usuário cadastrado com sucesso.')->send();
    }

    public function edit()
    {
        $user = User::findOrFail($this->userId);

        $rules = [
            'role' => 'required|in:Administrador,Funcionário',
            'name' => 'required|min:3',
            'username' => $this->role === 'Administrador' ? 'required|min:3|regex:/^\S*$/u|unique:users,username,' . $this->userId : 'nullable',
            'email' => 'nullable|email',
            'password' => 'nullable|min:3',
            'confirm_password' => 'nullable|same:password|min:3',
            'commission' => 'nullable|integer|numeric'
        ];

        if ($this->role === 'Administrador' && $user->role !== 'Administrador') {
            $rules['password'] = 'required|min:3';
            $rules['confirm_password'] = 'required|same:password|min:3';
        }

        if (!empty($this->password)) {
            $rules['password'] = 'required|min:3';
            $rules['confirm_password'] = 'required|same:password|min:3';
        }

        $messages = [
            'role.required' => 'O campo perfil é obrigatório',
            'role.in' => 'O campo perfil tem um valor inválido',
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome precisa ter no mínimo 3 caracteres.',
            'username.required' => 'O campo nome de usuário é obrigatório para administradores.',
            'username.unique' => 'Já existe um usuario com esse nome.',
            'username.regex' => 'O nome de usuário não pode ter espaços.',
            'password.required' => 'O campo senha é obrigatório para administradores.',
            'password.min' => 'A senha precisa ter no mínimo 3 caracteres.',
            'confirm_password.required' => 'O campo de confirmação de senha é obrigatório para administradores.',
            'confirm_password.same' => 'A confirmação da senha precisa coincidir com a senha.',
            'commission.integer' => 'O campo comissão deve ser um numero inteiro',
            'commission.numeric' => 'O campo comissão deve ser um número.'
        ];

        $this->validate($rules, $messages);

        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        if (!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }
        $user->role = $this->role === 'Administrador' ? 'admin' : 'func';
        $user->commission = $this->commission;
        $user->save();

        session()->flash('message', 'Usuário alterado com sucesso!');

        $this->redirectRoute('users');
    }
}
