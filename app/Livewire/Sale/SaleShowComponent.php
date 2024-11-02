<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Visualização da venda')]
class SaleShowComponent extends Component
{
    public $total_price;
    public $sale_date;
    public $description;
    public $is_paid;
    public $payment_type;

    public $addedProducts = [];

    public function mount($sale)
    {
        if ($sale) {
            $sale = Sale::findOrFail($sale);
            $this->total_price = $sale->total_price;
            $this->sale_date = $sale->sale_date;
            $this->is_paid = $sale->is_paid;
            $this->payment_type = $sale->payment_type;

            // Preencher a lista de produtos e suas quantidades
            foreach ($sale->products as $product) {
                $this->addedProducts[] = [
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => $product->pivot->unit_price,
                    'subtotal' => $product->pivot->subtotal,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.sale.sale-show-component');
    }
}
