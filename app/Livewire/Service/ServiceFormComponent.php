<?php

namespace App\Livewire\Service;

use App\Models\Product;
use App\Models\Service;
use App\Services\CostValueProductService;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Formulário de serviços')]
class ServiceFormComponent extends Component
{
    use Interactions;

    // Service inputs
    public $name;
    public $description;
    public $price;
    public $serviceId;
    public $type;

    //Product input
    public $product_id;
    public $used_quantity;
    public $qtd_used_per_service = 1;
    public $addedProducts = [];
    public $existingProductIds = [];

    public $productsOptionsSelect = [];

    public function mount($service = null)
    {
        $this->productsOptionsSelect = Product::select('id', 'name')
            ->get()
            ->map(function ($product) {
                return [
                    'label' => $product->name,
                    'value' => $product->id,
                    'step' => $product->qtd_used_per_service ?? 1
                ];
            });

        if ($service) {
            $service = Service::with('products')->findOrFail($service);
            $this->serviceId = $service->id;
            $this->name = $service->name;
            $this->description = $service->description;
            $this->price = $service->price;
            $this->type = 'edição';

            foreach ($service->products as $product) {
                $this->addedProducts[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->used_quantity,
                    'cost_price' => $product->pivot->cost_price,
                    'unit_type' => $product->unit_type,
                    'step' => $product->qtd_used_per_service ?? 1
                ];

                // Armazena os IDs de produtos existentes
                $this->existingProductIds[] = $product->id;
            }
        } else {
            $service = null;
            $this->type = 'cadastro';
        }
    }


    public function render()
    {
        return view('livewire.service.service-form-component');
    }

    public function handleAddProduct()
    {
        $this->validate([
            'product_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (collect($this->addedProducts)->contains('id', $value)) {
                        $fail('Este produto já foi adicionado.');
                    }
                },
            ],
        ]);

        $product = Product::find($this->product_id);

        // Verificar se o produto já está na lista
        if (collect($this->addedProducts)->contains('id', $this->product_id)) {
            session()->flash('error', 'Este produto já foi adicionado.');
            return;
        }

        $cost_price = CostValueProductService::costValueCalculator($this->product_id, $this->used_quantity);

        if ($this->product_id && $this->used_quantity) {
            $this->addedProducts[] = [
                'id' => $this->product_id,
                'quantity' => $this->used_quantity,
                'cost_price' => $cost_price,
                'name' => $this->getProductName($this->product_id),
                'unit_type' => $product->unit_type
            ];

            $this->product_id = null;
            $this->used_quantity = null;
        }
    }

    public function updatedProductId($productId)
    {
        if ($productId) {
            $product = Product::find($productId);
            if ($product) {
                $this->qtd_used_per_service = $product->qtd_used_per_service ?? 1;
            }
        }
    }

    private function getProductName($productId)
    {
        $product = Product::find($productId);
        return $product ? $product->name : 'Produto não encontrado';
    }

    public function removeProduct($index)
    {
        unset($this->addedProducts[$index]);
        $this->addedProducts = array_values($this->addedProducts);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:255',
            'price' => 'required',
            'addedProducts.*.id' => 'required|exists:products,id',
            'addedProducts.*.quantity' => 'required|numeric',
        ];

        if (count($this->addedProducts) === 0) {
            $rules['product_id'] = 'required|exists:products,id';
            $rules['used_quantity'] = 'required|numeric';
        }

        $messages = [
            'name.required' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'product_id.required' => 'Este campo é obrigatório.',
            'used_quantity.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'price.required' => 'Este campo é obrigatório.',
            'addedProducts.*.id.required' => 'Produto é obrigatório.',
            'addedProducts.*.id.exists' => 'Produto não encontrado.',
            'addedProducts.*.quantity.required' => 'Quantidade é obrigatória.',
            'addedProducts.*.quantity.numeric' => 'Quantidade deve ser numérica.',
        ];

        $this->validate($rules, $messages);

        $this->price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->price);

        $service = Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        foreach ($this->addedProducts as $addedProduct) {
            $costPrice = CostValueProductService::costValueCalculator($addedProduct['id'], $addedProduct['quantity']);

            $service->products()->attach(
                $addedProduct['id'],
                [
                    'used_quantity' => $addedProduct['quantity'],
                    'cost_price' => $costPrice
                ]
            );
        }

        $this->reset(['name', 'description', 'price', 'addedProducts']);

        return $this->toast()->success('Serviço cadastrado com sucesso.')->send();
    }

    public function edit()
    {
        $this->price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->price);

        $service = Service::findOrFail($this->serviceId);

        $rules = [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:255',
            'price' => 'required',
            'addedProducts.*.id' => 'required|exists:products,id',
            'addedProducts.*.quantity' => 'required|numeric',
        ];

        if (count($this->addedProducts) === 0) {
            $rules['product_id'] = 'required|exists:products,id';
            $rules['used_quantity'] = 'required|numeric';
        }

        $messages = [
            'name.required' => 'Este campo é obrigatório.',
            'name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'product_id.required' => 'Este campo é obrigatório.',
            'used_quantity.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'price.required' => 'Este campo é obrigatório.',
            'addedProducts.*.id.required' => 'Produto é obrigatório.',
            'addedProducts.*.id.exists' => 'Produto não encontrado.',
            'addedProducts.*.quantity.required' => 'Quantidade é obrigatória.',
            'addedProducts.*.quantity.numeric' => 'Quantidade deve ser numérica.',
        ];

        $this->validate($rules, $messages);

        $service->name = $this->name;
        $service->description = $this->description;
        $service->price = $this->price;

        $processedProductIds = [];

        foreach ($this->addedProducts as $addedProduct) {
            $costPrice = CostValueProductService::costValueCalculator($addedProduct['id'], $addedProduct['quantity']);

            if (in_array($addedProduct['id'], $this->existingProductIds)) {
                $service->products()->updateExistingPivot(
                    $addedProduct['id'],
                    [
                        'used_quantity' => $addedProduct['quantity'],
                        'cost_price' => $costPrice
                    ]
                );
            } else {
                $service->products()->attach(
                    $addedProduct['id'],
                    [
                        'used_quantity' => $addedProduct['quantity'],
                        'cost_price' => $costPrice
                    ]
                );
            }

            $processedProductIds[] = $addedProduct['id'];
        }

        $uniqueExistingIds = array_unique($this->existingProductIds);
        $productsToDetach = array_diff($uniqueExistingIds, $processedProductIds);
        // dd($processedProductIds);
        if (!empty($productsToDetach)) {
            $service->products()->detach($productsToDetach);
        }

        $service->save();

        session()->flash('message', 'Produto alterado com sucesso!');
        $this->redirectRoute('services');
    }
}
