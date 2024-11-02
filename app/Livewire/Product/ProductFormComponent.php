<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Services\PricePerService;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Criação de produtos')]
class ProductFormComponent extends Component
{
    use Interactions;

    public $productId;
    public $name;
    public $category;
    public $qtd_stock;
    public $qtd_min;
    public $unit_type;
    public $quantity;
    public $cost_price;
    public $sale_price;
    public $qtd_service;
    public $type;

    public function mount($product = null)
    {
        if ($product) {
            $product = Product::findOrFail($product);
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->category = $product->category;
            $this->qtd_stock = $product->qtd_stock;
            $this->qtd_min = $product->qtd_min;
            $this->unit_type = $product->unit_type;
            $this->quantity = $product->quantity;
            $this->cost_price = $product->cost_price;
            $this->sale_price = $product->sale_price;
            $this->qtd_service = $product->qtd_service;
            $this->type = 'edição';
        } else {
            $product = null;
            $this->type = 'criação';
        }
    }

    public function render()
    {
        return view('livewire.product.product-form-component');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min:3',
            'category' => 'nullable|min:3|unique:products',
            'qtd_stock' => 'nullable|numeric|integer',
            'qtd_min' => 'nullable|numeric|integer',
            'unit_type' => 'required|in:ML,Unidade',
            'quantity' => $this->unit_type === 'ML' ? 'required|integer|numeric' : 'nullable',
            'cost_price' => 'nullable',
            'sale_price' => 'nullable',
            'qtd_service' => 'required|numeric|min:0'
        ];

        $messages = [
            'unit_type.required' => 'Este campo é obrigatório',
            'unit_type.in' => 'Este campo tem um valor inválido',
            'name.required' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'category.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'category.unique' => 'Já existe uma categoria com esse nome.',
            'qtd_stock.numeric' => 'Este campo deve ser numérico.',
            'qtd_stock.integer' => 'Este campo deve ser um número inteiro.',
            'qtd_min.numeric' => 'Este campo deve ser numérico.',
            'qtd_min.integer' => 'Este campo deve ser um número inteiro.',
            'qtd_service.numeric' => 'Este campo deve ser numérico.',
            'qtd_service.required' => 'Este campo é obrigatório.',
            'qtd_service.min' => 'Este campo deve ser um número maior que 0.',
            'quantity.required' => 'Este campo é obrigatório.',
            'quantity.numeric' => 'Este campo deve ser numérico.',
            'quantity.integer' => 'Este campo deve ser um número inteiro.',
        ];

        $this->validate($rules, $messages);

        $this->cost_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->cost_price);
        $this->sale_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->sale_price);

        // Calculando custo por servico
        $price_per_service = PricePerService::calculatePricePerService($this->cost_price, $this->qtd_service);

        Product::create([
            'name' => $this->name,
            'category' => $this->category,
            'qtd_stock' => $this->qtd_stock,
            'qtd_min' => $this->qtd_min,
            'unit_type' => $this->unit_type === 'ML' ? 'ml' : 'un',
            'quantity' => $this->unit_type === 'Unidade' ? '1' : $this->quantity,
            'cost_price' => $this->cost_price,
            'sale_price' => $this->sale_price,
            'qtd_service' => $this->qtd_service,
            'cost_per_service' => $price_per_service,
            'qtd_used_per_service' => ($this->unit_type === 'Unidade' ? '1' : $this->quantity) / $this->qtd_service
        ]);

        $this->reset(['name', 'category', 'qtd_stock', 'qtd_min', 'unit_type', 'quantity', 'cost_price', 'sale_price', 'qtd_service']);
        return $this->toast()->success('Produto cadastrado com sucesso.')->send();
    }

    public function edit()
    {
        $product = Product::findOrFail($this->productId);

        $rules = [
            'name' => 'required|min:3',
            'category' => 'nullable|min:3|unique:products,category,' . $this->productId,
            'qtd_stock' => 'nullable|numeric|integer',
            'qtd_min' => 'nullable|numeric|integer',
            'unit_type' => 'required|in:ML,Unidade',
            'quantity' => $this->unit_type === 'ML' ? 'required|integer|numeric' : 'nullable',
            'cost_price' => 'nullable',
            'sale_price' => 'nullable',
            'qtd_service' => 'required|numeric|min:0'
        ];


        $messages = [
            'unit_type.required' => 'Este campo é obrigatório',
            'unit_type.in' => 'Este campo tem um valor inválido',
            'name.required' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'category.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'category.unique' => 'Já existe uma categoria com esse nome.',
            'qtd_stock.numeric' => 'Este campo deve ser numérico.',
            'qtd_stock.integer' => 'Este campo deve ser um número inteiro.',
            'qtd_min.numeric' => 'Este campo deve ser numérico.',
            'qtd_min.integer' => 'Este campo deve ser um número inteiro.',
            'quantity.required' => 'Este campo é obrigatório.',
            'quantity.numeric' => 'Este campo deve ser numérico.',
            'quantity.integer' => 'Este campo deve ser um número inteiro.',
            'qtd_service.numeric' => 'Este campo deve ser numérico.',
            'qtd_service.required' => 'Este campo é obrigatório.',
            'qtd_service.min' => 'Este campo deve ser um número maior que 0.',
        ];

        $this->validate($rules, $messages);

        $this->cost_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->cost_price);
        $this->sale_price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->sale_price);

        // Calculando custo por servico
        $cost_per_service = PricePerService::calculatePricePerService($this->cost_price, $this->qtd_service);

        $product->name = $this->name;
        $product->category = $this->category;
        $product->qtd_stock = $this->qtd_stock;
        $product->qtd_min = $this->qtd_min;
        $product->unit_type = $this->unit_type === 'ML' ? 'ml' : 'un';
        $product->quantity = $this->unit_type === 'Unidade' ? '1' : $this->quantity;
        $product->cost_price = $this->cost_price;
        $product->sale_price = $this->sale_price;
        $product->qtd_service = $this->qtd_service;
        $product->cost_per_service = $cost_per_service;
        $product->qtd_used_per_service = ($this->unit_type === 'Unidade' ? '1' : $this->quantity) / $this->qtd_service;
        $product->save();

        session()->flash('message', 'Produto alterado com sucesso!');

        $this->redirectRoute('products');
    }
}
