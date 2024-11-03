<?php

namespace App\Livewire\Dashboard;

use App\Models\Expense;
use App\Models\Sale;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;

class Status extends Component
{
    public $servicosMesAtual;
    public $servicosMesAnterior;
    public $diferencaServicos;
    public $entradasMesAtual;
    public $entradasMesAnterior;
    public $diferencaEntradas;
    public $percentualDiferencaEntradas;
    public $saidasMesAtual;
    public $saidasMesAnterior;
    public $percentualDiferencaSaidas;

    public $totalEntrada;

    public function mount()
    {
        $this->servicosMesAtual = Service::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $this->servicosMesAnterior = Service::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $this->diferencaServicos = $this->servicosMesAtual - $this->servicosMesAnterior;

        // Entradas do mês atual em services e sales onde is_paid é true
        // $entradasServicesMesAtual = Service::where('is_paid', true)
        //     ->whereMonth('created_at', Carbon::now()->month)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->sum('price');

        $entradasSalesMesAtual = Sale::where('is_paid', true)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // Entradas do mês anterior em services e sales onde is_paid é true
        // $entradasServicesMesAnterior = Service::where('is_paid', true)
        //     ->whereMonth('created_at', Carbon::now()->subMonth()->month)
        //     ->whereYear('created_at', Carbon::now()->subMonth()->year)
        //     ->sum('price');

        $entradasSalesMesAnterior = Sale::where('is_paid', true)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_price');

        // Total de entradas para o mês atual e o mês anterior
        // $this->entradasMesAtual = $entradasServicesMesAtual + $entradasSalesMesAtual;
        // $this->entradasMesAnterior = $entradasServicesMesAnterior + $entradasSalesMesAnterior;

        // Comparação entre os dois meses
        if ($this->entradasMesAnterior > 0) {
            $this->percentualDiferencaEntradas = ($this->diferencaEntradas / $this->entradasMesAnterior) * 100;
        } else {
            $this->percentualDiferencaEntradas = 0;
        }

        // Saídas do mês atual em expense is_paid é true
        $this->saidasMesAtual = Expense::where('is_paid', true)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('value');

        // Saídas do mês anterior em expense onde is_paid é true
        $this->saidasMesAnterior = Expense::where('is_paid', true)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('value');

        // Comparação entre os dois meses
        if ($this->saidasMesAnterior > 0) {
            $this->percentualDiferencaEntradas = (($this->saidasMesAtual - $this->saidasMesAnterior) / $this->saidasMesAnterior) * 100;
        } else {
            $this->percentualDiferencaSaidas = 0;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.status');
    }
}
