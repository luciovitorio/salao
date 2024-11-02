<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use App\Services\StockService;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Vendas')]
class SaleComponent extends Component
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
            ['index' => 'sale_date', 'label' => 'Data da venda'],
            ['index' => 'total_price', 'label' => 'Valor Total'],
            ['index' => 'is_paid', 'label' => 'Status'],
            ['index' => 'payment_type', 'label' => 'Forma de pagamento'],
            ['index' => 'action'],
        ];

        $rows = Sale::where('sale_date', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);


        return view('livewire.sale.sale-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($saleId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $saleId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($saleId): void
    {
        $sale = Sale::findOrFail($saleId);

        // Devolver o estoque dos produtos antes de excluir
        foreach ($sale->products as $product) {
            StockService::updateStock($product->id, $product->pivot->quantity);
        }

        // Remover produtos associados na tabela pivot
        $sale->products()->detach();
        $sale->delete();

        $this->dialog()->success('Venda excluída com sucesso!')->send();
    }

    public function cancelled(): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
