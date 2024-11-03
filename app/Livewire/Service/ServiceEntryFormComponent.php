<?php

namespace App\Livewire\Service;

use App\Models\Service;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Formulário de entrada serviços')]
class ServiceEntryFormComponent extends Component
{
    use Interactions;

    public $service_id;

    public $price;
    public $servicesOptionsSelect = [];
    public $usersOptionsSelect = [];

    public function mount($service = null)
    {
        $this->servicesOptionsSelect = Service::select('id', 'name', 'price')
            ->get()
            ->map(function ($service) {
                return [
                    'label' => $service->name,
                    'value' => $service->id,
                    'price' => $service->price
                ];
            });

        $this->usersOptionsSelect = User::select('id', 'name')
            ->get()
            ->map(function ($user) {
                return [
                    'label' => $user->name,
                    'value' => $user->id,
                ];
            });

        if ($service) {
            $this->service_id = $service;
            $this->setPriceFromService();
        }
    }

    public function updatedServiceId()
    {
        $this->setPriceFromService();
    }

    protected function setPriceFromService()
    {
        $selectedService = collect($this->servicesOptionsSelect)
            ->firstWhere('value', $this->service_id);

        $this->price = $selectedService ? 'R$ ' . number_format($selectedService['price'], 2, ',', '.') : null;
    }


    public function render()
    {
        return view('livewire.service.service-entry-form-component');
    }
}
