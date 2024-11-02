<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Despesas')]
class ExpensesComponent extends Component
{
    use Interactions;
    use WithPagination;

    public ?int $quantity  = 5;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'desc',
    ];

    public function render()
    {
        $headers =  [
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'value', 'label' => 'Valor'],
            ['index' => 'due_date', 'label' => 'Vencimento'],
            ['index' => 'is_paid', 'label' => 'Status'],
            ['index' => 'action'],
        ];

        $rows = Expense::where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);

        return view('livewire.expenses.expenses-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($expenseId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $expenseId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($expenseId): void
    {
        $expense = Expense::findOrFail($expenseId);
        $expense->delete();

        $this->dialog()->success('Despesa excluída com sucesso!')->send();
    }

    public function cancelled(): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
