<?php

namespace App\Livewire\Report;

use App\Models\Sale;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Relatórios de lucro')]
class ReportCashComponent extends Component
{
    public  $startDate;
    public  $endDate;
    public $sales;

    public $totalSales;
    public $totalServices;

    public $services;

    public $isSearched = false;
    public function mount()
    {
        // Inicialize as variáveis como coleções vazias para evitar erro no Blade
        $this->sales = collect();
        $this->services = collect();
    }

    public function render()
    {
        return view('livewire.report.report-cash-component');
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
        $this->sales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('is_paid', 1)
            ->get() ?? collect();

        $this->services = Service::whereBetween('created_at', [$startDate, $endDate])
            ->where('is_paid', 1)
            ->get() ?? collect();

        $this->totalSales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('is_paid', 1)
            ->sum('total_price');

        $this->totalServices = Service::whereBetween('created_at', [$startDate, $endDate])
            ->where('is_paid', 1)
            ->sum('profit');

        $this->isSearched = true;
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'sales', 'isSearched']);
    }
}
