<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Produtos')]
class ProductComponent extends Component
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
            ['index' => 'category', 'label' => 'Categoria'],
            ['index' => 'qtd_stock', 'label' => 'Qtd estoque'],
            ['index' => 'cost_price', 'label' => 'Preço custo'],
            ['index' => 'sale_price', 'label' => 'Preço venda'],
            ['index' => 'action'],
        ];

        $rows = Product::where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);

        return view('livewire.product.product-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($productId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $productId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($productId): void
    {
        $product = Product::findOrFail($productId);
        $product->delete();

        $this->dialog()->success('Produto excluído com sucesso!')->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
