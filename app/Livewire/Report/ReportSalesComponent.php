<?php

namespace App\Livewire\Report;

use App\Models\Sale;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Relatórios de vendas')]
class ReportSalesComponent extends Component
{
    public  $startDate;
    public  $endDate;
    public $sales;
    public $totalValue;
    public $isSearched = false;

    public function render()
    {
        return view('livewire.report.report-sales-component');
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
            ->with('products')
            ->get();

        $this->totalValue = $this->sales->sum('total_price');

        $this->isSearched = true;
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'sales', 'isSearched']);
    }
}
