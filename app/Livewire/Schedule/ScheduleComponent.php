<?php

namespace App\Livewire\Schedule;

use App\Models\Schedule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Agendamentos')]
class ScheduleComponent extends Component
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
            ['index' => 'client_name', 'label' => 'Cliente'],
            ['index' => 'service_name', 'label' => 'Serviço'],
            ['index' => 'user_id', 'label' => 'Profissional'],
            ['index' => 'schedule_data', 'label' => 'Data'],
            ['index' => 'schedule_time', 'label' => 'Hora'],
            ['index' => 'price', 'label' => 'Preço'],
            ['index' => 'action'],
        ];

        $rows = Schedule::where('client_name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);


        return view('livewire.schedule.schedule-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($scheduleId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $scheduleId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($scheduleId): void
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->delete();

        $this->dialog()->success('Agendamento excluído com sucesso!')->send();
    }

    public function deleteAll()
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir TODOS os registros?')
            ->confirm('Excluir', 'confirmedAll')
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmedAll($scheduleId): void
    {
        Schedule::truncate();

        $this->dialog()->success('Todos os registros excluídos com sucesso!')->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
