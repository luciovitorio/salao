<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;

class InventoryShowComponent extends Component
{

    public $productName;
    public $quantity;
    public $entry_date;
    public $unit_price;
    public $total_cost;
    public $description;

    public function mount(Inventory $inventory)
    {
        $this->unit_price = $inventory->unit_price;
        $this->quantity = $inventory->quantity;
        $this->entry_date = $inventory->entry_date;
        $this->total_cost = $inventory->total_cost;
        $this->description = $inventory->description;
        $this->productName = $inventory->product->name;
    }

    public function render()
    {
        return view('livewire.inventory.inventory-show-component');
    }
}
