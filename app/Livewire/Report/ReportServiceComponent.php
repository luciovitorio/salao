<?php

namespace App\Livewire\Report;

use App\Models\Service;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Relatórios de serviços')]
class ReportServiceComponent extends Component
{
    public  $startDate;
    public  $endDate;
    public $services;
    public $totalValue;
    public bool $isSearched = false;

    public function render()
    {
        return view('livewire.report.report-service-component');
    }

    public function generateReport()
    {
        $rules = [
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ];

        $messages = [
            'startDate.required' => 'Este campo é obrigatório',
            'startDate.date' => 'Informe uma data válida',
            'endDate.required' => 'Este campo é obrigatório',
            'endDate.date' => 'Informe uma data válida',
        ];

        $this->validate($rules, $messages);

        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // Obter todos os serviços dentro do intervalo de datas
        $this->services = Service::whereBetween('created_at', [$startDate, $endDate])
            ->with('user')
            ->get();

        $this->totalValue = $this->services->sum('price');

        $this->isSearched = true;
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'services', 'isSearched']);
    }
}
