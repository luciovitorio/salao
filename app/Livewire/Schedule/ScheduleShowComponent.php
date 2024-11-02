<?php

namespace App\Livewire\Schedule;

use App\Models\Schedule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Visualização do agendamento')]
class ScheduleShowComponent extends Component
{
    public $userName;
    public $client_name;
    public $service_name;
    public $schedule_date;
    public $schedule_time;
    public $price;
    public $description;

    public function mount($schedule)
    {
        if ($schedule) {
            $schedule = Schedule::findOrFail($schedule);
            $this->userName = $schedule->user->name;
            $this->client_name = $schedule->client_name;
            $this->service_name = $schedule->service_name;
            $this->schedule_date = $schedule->schedule_date;
            $this->schedule_time = $schedule->schedule_time;
            $this->price = $schedule->price;
            $this->description = $schedule->description;
        }
    }
    public function render()
    {
        return view('livewire.schedule.schedule-show-component');
    }
}
