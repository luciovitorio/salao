<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class ExpensesShowComponent extends Component
{
    public $name;
    public $value;
    public $is_paid;
    public $description;
    public $due_date;
    public $remember_me;

    public function mount($expense)
    {
        if ($expense) {
            $expense = Expense::findOrFail($expense);
            $this->name = $expense->name;
            $this->value = $expense->value;
            $this->is_paid = $expense->is_paid;
            $this->description = $expense->description;
            $this->due_date = $expense->due_date;
            $this->remember_me = $expense->remember_me;
        }
    }
    public function render()
    {
        return view('livewire.expenses.expenses-show-component');
    }
}
