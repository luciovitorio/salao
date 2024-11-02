<?php

namespace App\Livewire\Dashboard;

use App\Models\Product;
use Livewire\Component;

class TableStock extends Component
{
    public $stockLow;

    public function mount()
    {
        $this->stockLow = Product::whereColumn('qtd_stock', '<=', 'qtd_min')->get();
    }
    public function render()
    {
        return view('livewire.dashboard.table-stock');
    }
}
