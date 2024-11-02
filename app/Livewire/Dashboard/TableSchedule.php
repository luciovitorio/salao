<?php

namespace App\Livewire\Dashboard;

use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Component;

class TableSchedule extends Component
{
    public $schedules;

    public function mount()
    {
        $this->schedules = Schedule::where(function ($query) {
            $query->whereDate('schedule_date', '>', Carbon::today())
                ->orWhere(function ($query) {
                    $query->whereDate('schedule_date', Carbon::today())
                        ->whereTime('schedule_time', '>=', Carbon::now()->format('H:i'));
                });
        })
            ->with('user')
            ->get();
    }
    public function render()
    {
        return view('livewire.dashboard.table-schedule');
    }
}
