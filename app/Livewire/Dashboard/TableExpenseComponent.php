<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TableExpenseComponent extends Component
{
    public $dueExpensesToday = [];

    public function mount()
    {
        $this->dueExpensesToday = Cache::get('due_expenses_today', collect())->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.table-expense-component');
    }
}
