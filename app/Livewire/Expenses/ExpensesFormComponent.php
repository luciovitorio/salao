<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ExpensesFormComponent extends Component
{
    use Interactions;

    public ?int $quantity  = 5;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'desc',
    ];

    public $name;
    public $value;
    public $is_paid;
    public $description;
    public $due_date;
    public $remember_me;
    public $expenseId;

    public $type;

    public function mount($expense = null)
    {
        if ($expense) {
            $expense = Expense::findOrFail($expense);
            $this->expenseId = $expense->id;
            $this->name = $expense->name;
            $this->value = $expense->value;
            $this->is_paid = $expense->is_paid;
            $this->description = $expense->description;
            $this->due_date = $expense->due_date;
            $this->remember_me = $expense->remember_me;
            $this->type = 'edição';
        } else {
            $service = null;
            $this->type = 'cadastro';
        }
    }
    public function render()
    {
        return view('livewire.expenses.expenses-form-component');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'value' => 'required',
            'description' => 'nullable|min:3|max:255',
            'due_date' => 'required|date'
        ];

        $messages = [
            'name' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'value.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'due_date.required' => 'A data é obrigatória.',
            'due_date.date' => 'Por favor, insira uma data válida.',
        ];

        $this->validate($rules, $messages);

        $this->value = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->value);

        Expense::create([
            'name' => $this->name,
            'value' => $this->value,
            'description' => $this->description,
            'is_paid' => $this->is_paid,
            'remember_me' => $this->remember_me,
            'due_date' => $this->due_date
        ]);

        $this->reset(['name', 'value', 'description', 'is_paid', 'remember_me', 'due_date']);

        return $this->toast()->success('Despesa cadastrada com sucesso.')->send();
    }

    public function edit()
    {
        $expense = Expense::findOrFail($this->expenseId);

        $rules = [
            'name' => 'required|min:3|max:255',
            'value' => 'required',
            'description' => 'nullable|min:3|max:255',
            'due_date' => 'required|date'
        ];

        $messages = [
            'name' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'value.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'due_date.required' => 'A data é obrigatória.',
            'due_date.date' => 'Por favor, insira uma data válida.',
        ];

        $this->validate($rules, $messages);

        $this->value = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->value);

        $expense->name = $this->name;
        $expense->value = $this->value;
        $expense->is_paid = $this->is_paid;
        $expense->description = $this->description;
        $expense->due_date = $this->due_date;
        $expense->remember_me = $this->remember_me;

        $expense->save();

        session()->flash('message', 'Despesa alterada com sucesso!');
        $this->redirectRoute('expenses');
    }
}
