<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $toogleMenu = false;
    public function render()
    {
        return view('livewire.dashboard.header-component');
    }

    public function toggleMenu()
    {
        $this->toogleMenu = !$this->toogleMenu;
    }

    public function closeMenu()
    {
        $this->toogleMenu = false;
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
