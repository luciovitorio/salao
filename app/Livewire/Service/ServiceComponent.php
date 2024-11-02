<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Serviços')]
class ServiceComponent extends Component
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
            ['index' => 'price', 'label' => 'Valor'],
            ['index' => 'description', 'label' => 'Observação'],
            ['index' => 'action'],
        ];

        $rows = Service::where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);

        return view('livewire.service.service-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($serviceId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $serviceId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($serviceId): void
    {
        $service = Service::findOrFail($serviceId);

        // Devolver o estoque dos produtos antes de excluir
        foreach ($service->products as $product) {
            $product->qtd_stock += $product->pivot->used_quantity;
            $product->save();
        }

        // Remover produtos associados na tabela pivot
        $service->products()->detach();
        $service->delete();

        $this->dialog()->success('Serviço excluído com sucesso!')->send();
    }

    public function cancelled(): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }

    public function makeSell()
    {
        $this->redirectRoute('services.sell');
    }
}
