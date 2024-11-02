<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Services\StockService;
use Exception;

#[Title('Entrada de produtos')]
class InventoryFormComponent extends Component
{
    use Interactions;

    public $productsOptionsSelect = [];

    public $product_id;
    public $quantity;
    public $entry_date;
    public $unit_price;
    public $total_cost;
    public $description;

    public $inventoryId;
    public $type;

    public function mount($inventory = null)
    {
        $this->productsOptionsSelect = Product::select('id', 'name')
            ->get()
            ->map(function ($user) {
                return [
                    'label' => $user->name,
                    'value' => $user->id
                ];
            });

        if ($inventory) {
            $inventory = Inventory::findOrFail($inventory);
            $this->inventoryId = $inventory->id;
            $this->quantity = $inventory->quantity;
            $this->entry_date = $inventory->entry_date;
            $this->unit_price = $inventory->unit_price;
            $this->total_cost = $inventory->total_cost;
            $this->description = $inventory->description;
            $this->product_id = $inventory->product_id;
            $this->type = 'edição';
        } else {
            $service = null;
            $this->type = 'cadastro';
        }
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form-component');
    }

    public function create(StockService $stockService)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'entry_date' => 'required|date',
            'unit_price' => 'required|min:1',
            'description' => 'nullable|min:3|max:255',
        ];

        $messages = [
            'product_id.required' => 'Este campo é obrigatório.',
            'product_id.exists' => 'Produto selecionado não é válido.',
            'quantity.required' => 'Este campo é obrigatório.',
            'quantity.numeric' => 'Este campo deve ser um número.',
            'quantity.min' => 'O valor deve ser maior que 0.',
            'entry_date.required' => 'Este campo é obrigatório.',
            'entry_date.date' => 'Por favor, insira uma data válida.',
            'unit_price.required' => 'Este campo é obrigatório.',
            'unit_price.min' => 'O valor deve ser maior que 0.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
        ];

        $this->validate($rules, $messages);

        $this->unit_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->unit_price);

        // calculando o valor total da entrada
        $totalValue = $this->quantity * $this->unit_price;


        Inventory::create([
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'entry_date' => $this->entry_date,
            'unit_price' => $this->unit_price,
            'total_cost' => $totalValue,
            'description' => $this->description,
        ]);

        $product = Product::findOrFail($this->product_id);
        $product->cost_price = $this->unit_price;
        $product->save();

        try {
            $stockService->updateStock($this->product_id, $this->quantity);

            $this->reset(['product_id', 'quantity', 'entry_date', 'unit_price', 'total_cost', 'description']);

            return $this->toast()->success('Entrada realizada com sucesso, estoque atualizado')->send();
        } catch (Exception  $e) {
            return $this->toast()->error('Produto não encontrado')->send();
        }
    }

    public function edit(StockService $stockService)
    {
        $inventory = Inventory::findOrFail($this->inventoryId);

        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'entry_date' => 'required|date',
            'unit_price' => 'required|min:1',
            'description' => 'nullable|min:3|max:255',
        ];

        $messages = [
            'product_id.required' => 'Este campo é obrigatório.',
            'product_id.exists' => 'Produto selecionado não é válido.',
            'quantity.required' => 'Este campo é obrigatório.',
            'quantity.numeric' => 'Este campo deve ser um número.',
            'quantity.min' => 'O valor deve ser maior que 0.',
            'entry_date.required' => 'Este campo é obrigatório.',
            'entry_date.date' => 'Por favor, insira uma data válida.',
            'unit_price.required' => 'Este campo é obrigatório.',
            'unit_price.min' => 'O valor deve ser maior que 0.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
        ];

        $this->validate($rules, $messages);

        $this->unit_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->unit_price);

        // calculando o valor total da entrada
        $totalValue = $this->quantity * $this->unit_price;

        $inventory->product_id = $this->product_id;
        $inventory->quantity =  $this->quantity;
        $inventory->entry_date = $this->entry_date;
        $inventory->unit_price = $this->unit_price;
        $inventory->total_cost = $totalValue;
        $inventory->description =  $this->description;

        $product = Product::findOrFail($this->product_id);
        $product->cost_price = $this->unit_price;
        $product->save();

        try {
            $stockService->updateStockEntry($this->inventoryId, $this->quantity);

            $this->reset(['product_id', 'quantity', 'entry_date', 'unit_price', 'total_cost', 'description']);

            return $this->toast()->success('Entrada atualizada com sucesso, estoque atualizado')->send();
        } catch (Exception  $e) {
            return $this->toast()->error('Entrada não encontrada')->send();
        }
    }
}
