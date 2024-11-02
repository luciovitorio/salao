<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Visualização do serviço')]
class ServiceShowComponent extends Component
{
    public $name;
    public $description;
    public $price;
    public $addedProducts = [];

    public function mount($service)
    {
        if ($service) {
            $service = Service::findOrFail($service);
            $this->name = $service->name;
            $this->description = $service->description;
            $this->price = $service->price;

            // Preencher a lista de produtos e suas quantidades
            foreach ($service->products as $product) {
                $this->addedProducts[] = [
                    'name' => $product->name,
                    'quantity' => $product->pivot->used_quantity,
                    'unit_type' => $product->unit_type,
                    'cost_price' => $product->pivot->cost_price,
                ];
            }
        }
    }
    public function render()
    {
        return view('livewire.service.service-show-component');
    }
}
