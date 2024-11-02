<?php

namespace App\Livewire\Sale;

use App\Models\Product;
use App\Models\Sale;
use App\Services\StockService;
use Livewire\Component;

use Livewire\Attributes\Title;
use TallStackUi\Traits\Interactions;

#[Title('Formulário de venda')]
class SaleFormComponent extends Component
{
    use Interactions;

    public $total_price;
    public $sale_date;
    public $description;
    public $is_paid;
    public $payment_type;

    public $type;

    public $product_id;
    public $used_quantity;

    public $saleId;

    public $addedProducts = [];
    public $productsOptionsSelect = [];

    public $existingProductIds = [];

    public function mount($sale = null)
    {
        $this->productsOptionsSelect = Product::select('id', 'name')
            ->get()
            ->map(function ($user) {
                return [
                    'label' => $user->name,
                    'value' => $user->id
                ];
            });

        if ($sale) {
            $sale = Sale::with('products')->findOrFail($sale);
            $this->saleId = $sale->id;
            $this->total_price = $sale->total_price;
            $this->sale_date = $sale->sale_date;
            $this->description = $sale->description;
            $this->is_paid = $sale->is_paid;
            $this->payment_type = $sale->payment_type;
            $this->type = 'edição';

            foreach ($sale->products as $product) {
                $this->addedProducts[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'sale_price' => $product->sale_price
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
        return view('livewire.sale.sale-form-component');
    }

    public function handleAddProduct()
    {
        $product = Product::find($this->product_id);

        if ($this->product_id && $this->used_quantity) {
            $this->addedProducts[] = [
                'id' => $this->product_id,
                'quantity' => $this->used_quantity,
                'name' => $this->getProductName($this->product_id),
                'sale_price' => $product->sale_price
            ];

            $this->product_id = null;
            $this->used_quantity = null;

            $this->calculateTotal();
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

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_price = 0;
        foreach ($this->addedProducts as $product) {
            $this->total_price += $product['quantity'] * $product['sale_price'];
        }
    }

    public function create(StockService $stockService)
    {
        $paymentTypeMap = [
            'Pix' => 'pix',
            'Dinheiro' => 'money',
            'Cartão' => 'credit_card',
        ];

        $paymentType = $paymentTypeMap[$this->payment_type] ?? null;

        $rules = [
            'description' => 'nullable|min:3|max:255',
            'sale_date' => 'required|date',
            'addedProducts.*.id' => 'required|exists:products,id',
            'addedProducts.*.quantity' => 'required|numeric',
            'payment_type' => 'required|in:Pix,Dinheiro,Cartão'
        ];

        if (count($this->addedProducts) === 0) {
            $rules['product_id'] = 'required|exists:products,id';
            $rules['used_quantity'] = 'required|numeric';
        }

        $messages = [
            'payment_type.required' => 'Este campo é obrigatório.',
            'payment_type.in' => 'Favor informar uma opção válida.',
            'used_quantity.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'sale_date.required' => 'A data do serviço é obrigatória.',
            'sale_date.date' => 'Por favor, insira uma data válida.',
            'addedProducts.*.id.required' => 'Produto é obrigatório.',
            'addedProducts.*.id.exists' => 'Produto não encontrado.',
            'addedProducts.*.quantity.required' => 'Quantidade é obrigatória.',
            'addedProducts.*.quantity.numeric' => 'Quantidade deve ser numérica.',
        ];

        $this->validate($rules, $messages);

        $sale = Sale::create([
            'total_price' => $this->total_price,
            'sale_date' => $this->sale_date,
            'description' => $this->description,
            'is_paid' => true,
            'payment_type' => $paymentType
        ]);

        foreach ($this->addedProducts as $product) {
            $sale->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'unit_price' => $product['sale_price'],
                'subtotal' => $product['quantity'] * $product['sale_price'],
            ]);

            // Atualizar o estoque do produto
            $stockService->decreaseStock($product['id'], $product['quantity']);
        }



        $this->reset(['total_price', 'sale_date', 'description', 'is_paid', 'payment_type', 'addedProducts']);

        return $this->toast()->success('Venda cadastrada com sucesso.')->send();
    }

    public function edit(StockService $stockService)
    {
        $paymentTypeMap = [
            'Pix' => 'pix',
            'Dinheiro' => 'money',
            'Cartão' => 'credit_card',
        ];

        $paymentType = $paymentTypeMap[$this->payment_type] ?? null;

        $sale = Sale::findOrFail($this->saleId);

        $rules = [
            'description' => 'nullable|min:3|max:255',
            'sale_date' => 'required|date',
            'addedProducts.*.id' => 'required|exists:products,id',
            'addedProducts.*.quantity' => 'required|numeric',
            'payment_type' => 'required|in:Pix,Dinheiro,Cartão'
        ];

        if (count($this->addedProducts) === 0) {
            $rules['product_id'] = 'required|exists:products,id';
            $rules['used_quantity'] = 'required|numeric';
        }

        $messages = [
            'payment_type.required' => 'Este campo é obrigatório.',
            'payment_type.in' => 'Favor informar uma opção válida.',
            'used_quantity.required' => 'Este campo é obrigatório.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'sale_date.required' => 'A data do serviço é obrigatória.',
            'sale_date.date' => 'Por favor, insira uma data válida.',
            'addedProducts.*.id.required' => 'Produto é obrigatório.',
            'addedProducts.*.id.exists' => 'Produto não encontrado.',
            'addedProducts.*.quantity.required' => 'Quantidade é obrigatória.',
            'addedProducts.*.quantity.numeric' => 'Quantidade deve ser numérica.',
        ];

        $this->validate($rules, $messages);

        // Array para armazenar IDs de produtos processados
        $processedProductIds = [];

        // Verificar os produtos atualmente associados ao serviço
        $currentProducts = $sale->products;

        // Atualizar ou adicionar produtos na tabela pivot e ajustar o estoque
        foreach ($this->addedProducts as $addedProduct) {
            $product = Product::find($addedProduct['id']); // Buscar o produto

            if (!$product) {
                continue;
            }

            // Verifica se o produto já estava associado à venda
            if (in_array($addedProduct['id'], $this->existingProductIds)) {
                // Produto já existe, atualizar a quantidade
                $pivot = $sale->products()->where('product_id', $addedProduct['id'])->first()->pivot;
                $oldQuantity = $pivot->quantity;

                // Restaurar estoque com a quantidade anterior e reduzir a nova
                $stockService->updateStock($addedProduct['id'], $oldQuantity); // Restaurar estoque antigo
                $stockService->decreaseStock($addedProduct['id'], $addedProduct['quantity']); // Reduzir novo

                // Atualizar a quantidade no pivot
                $sale->products()->updateExistingPivot($addedProduct['id'], ['quantity' => $addedProduct['quantity']]);
            } else {
                // Produto é novo, adicionar e ajustar o estoque
                $sale->products()->attach($addedProduct['id'], [
                    'quantity' => $addedProduct['quantity'],
                    'unit_price' => $addedProduct['sale_price'],
                    'subtotal' => $addedProduct['quantity'] * $addedProduct['sale_price'],
                ]);

                // Reduzir estoque para o produto novo
                $stockService->decreaseStock($addedProduct['id'], $addedProduct['quantity']);
            }

            // Armazena o ID dos produtos processados
            $processedProductIds[] = $addedProduct['id'];
        }

        // Remover produtos que foram removidos da lista e restaurar o estoque
        foreach ($currentProducts as $currentProduct) {
            if (!in_array($currentProduct->id, $processedProductIds)) {
                // Recuperar a quantidade no pivot para restaurar estoque corretamente
                $pivot = $sale->products()->where('product_id', $currentProduct->id)->first()->pivot;
                $quantityToRestore = $pivot->quantity;

                // Restaurar o estoque do produto removido
                $stockService->updateStock($currentProduct->id, $quantityToRestore);

                // Remover a relação da tabela pivot
                $sale->products()->detach($currentProduct->id);
            }
        }

        $sale->total_price = $this->total_price;
        $sale->sale_date = $this->sale_date;
        $sale->description = $this->description;
        $sale->is_paid = true;
        $sale->payment_type = $paymentType;

        $sale->save();

        session()->flash('message', 'Venda alterada com sucesso!');
        $this->redirectRoute('sales');
    }
}
