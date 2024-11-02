<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class DashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-component');
    }
}
