<?php

namespace App\Livewire\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Formulário de agendamentos')]
class ScheduleFormComponent extends Component
{

    use Interactions;

    public $user_id;
    public $client_name;
    public $service_name;
    public $schedule_date;
    public $schedule_time;
    public $price;
    public $description;
    public $scheduleId;
    public $type;

    public $usersOptionsSelect = [];

    public function mount($schedule = null)
    {
        $this->usersOptionsSelect = User::select('id', 'name')
            ->get()
            ->map(function ($user) {
                return [
                    'label' => $user->name,
                    'value' => $user->id
                ];
            });

        if ($schedule) {
            $schedule = Schedule::findOrFail($schedule);
            $this->scheduleId = $schedule->id;
            $this->user_id = $schedule->user_id;
            $this->client_name = $schedule->client_name;
            $this->service_name = $schedule->service_name;
            $this->schedule_date = $schedule->schedule_date;
            $this->schedule_time = $schedule->schedule_time;
            $this->price = $schedule->price;
            $this->description = $schedule->description;
            $this->type = 'edição';
        } else {
            $service = null;
            $this->type = 'cadastro';
        }
    }

    public function render()
    {
        return view('livewire.schedule.schedule-form-component');
    }

    public function create()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'client_name' => 'required|min:3|max:255',
            'service_name' => 'required|min:3|max:255',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required|date_format:H:i',
            'description' => 'nullable|min:3|max:255',
        ];

        $messages = [
            'user_id.required' => 'Este campo é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não é válido.',
            'client_name.required' => 'Este campo é obrigatório.',
            'client_name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'client_name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'service_name.required' => 'Este campo é obrigatório.',
            'service_name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'service_name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'schedule_date.required' => 'A data do serviço é obrigatória.',
            'schedule_date.date' => 'Por favor, insira uma data válida.',
            'schedule_time.required' => 'A data do serviço é obrigatória.',
            'schedule_time.time' => 'Por favor, insira uma hora válida.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
        ];

        $this->validate($rules, $messages);

        $this->price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->price);

        Schedule::create([
            'user_id' => $this->user_id,
            'client_name' => $this->client_name,
            'service_name' => $this->service_name,
            'schedule_date' => $this->schedule_date,
            'schedule_time' => $this->schedule_time,
            'price' => $this->price,
            'description' => $this->description,
        ]);

        $this->reset(['user_id', 'client_name', 'service_name', 'schedule_date', 'schedule_time', 'price', 'description']);

        return $this->toast()->success('Agendamento cadastrado com sucesso.')->send();
    }

    public function edit()
    {
        $schedule = Schedule::findOrFail($this->scheduleId);

        $rules = [
            'user_id' => 'required|exists:users,id',
            'client_name' => 'required|min:3|max:255',
            'service_name' => 'required|min:3|max:255',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required|date_format:H:i',
            'description' => 'nullable|min:3|max:255',
        ];

        $messages = [
            'user_id.required' => 'Este campo é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não é válido.',
            'client_name.required' => 'Este campo é obrigatório.',
            'client_name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'client_name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'service_name.required' => 'Este campo é obrigatório.',
            'service_name.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'service_name.max' => 'Este campo pode ter no máximo 255 caracteres.',
            'schedule_date.required' => 'A data do serviço é obrigatória.',
            'schedule_date.date' => 'Por favor, insira uma data válida.',
            'schedule_time.required' => 'A data do serviço é obrigatória.',
            'schedule_time.time' => 'Por favor, insira uma hora válida.',
            'description.min' => 'Este campo precisa ter no mínimo 3 caracteres.',
            'description.max' => 'Este campo pode ter no máximo 255 caracteres.',
        ];

        $this->validate($rules, $messages);

        $this->price = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $this->price);

        $schedule->user_id = $this->user_id;
        $schedule->client_name = $this->client_name;
        $schedule->service_name = $this->service_name;
        $schedule->schedule_date = $this->schedule_date;
        $schedule->schedule_time = $this->schedule_time;
        $schedule->price = $this->price;
        $schedule->description = $this->description;
        $schedule->save();

        session()->flash('message', 'Agendamento alterado com sucesso!');

        $this->redirectRoute('schedules');
    }
}
