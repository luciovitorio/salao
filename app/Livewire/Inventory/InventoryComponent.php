<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;
use App\Services\StockService;

#[Title('Lista de entradas')]
class InventoryComponent extends Component
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
            ['index' => 'product_id', 'label' => 'Produto'],
            ['index' => 'quantity', 'label' => 'Quantidade'],
            ['index' => 'entry_date', 'label' => 'Data da entrada'],
            ['index' => 'unit_price', 'label' => 'Preço unitário'],
            ['index' => 'total_cost', 'label' => 'Valor Total'],
            ['index' => 'action'],
        ];

        $rows = Inventory::where('entry_date', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);

        return view('livewire.inventory.inventory-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($inventoryId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $inventoryId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($inventoryId): void
    {
        // Nessa função eu atualizo o estoque e já removo a entrada na tabela inventory
        StockService::deleteStockEntry($inventoryId);

        $this->dialog()->success('Entrada excluída com sucesso! Estoque atualizado.')->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
