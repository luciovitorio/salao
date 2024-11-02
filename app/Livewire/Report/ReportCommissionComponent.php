<?php

namespace App\Livewire\Report;

use App\Models\User;
use App\Services\CommissionCalculatorService;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Relatórios de comissão')]
class ReportCommissionComponent extends Component
{
    public  $startDate;
    public  $endDate;
    public $user_id;
    public $commission = null;
    public $isSearched = false;
    public $usersOptionsSelect = [];

    public function mount()
    {
        $this->usersOptionsSelect = User::select('id', 'name')
            ->get()
            ->map(function ($user) {
                return [
                    'label' => $user->name,
                    'value' => $user->id
                ];
            });
    }

    public function render()
    {
        return view('livewire.report.report-commission-component');
    }

    public function generateReport()
    {
        $rules = [
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ];

        $messages = [
            'startDate.required' => 'Este campo é obrigatório',
            'startDate.date' => 'Informe uma data válida',
            'endDate.required' => 'Este campo é obrigatório',
            'endDate.date' => 'Informe uma data válida',
            'user_id.required' => 'Este campo é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não é válido.',
        ];

        $this->validate($rules, $messages);

        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $this->isSearched = true;

        $this->commission = CommissionCalculatorService::calculateUserCommissionReport(
            $startDate,
            $endDate,
            $this->user_id
        );

        // dd($this->commission);
    }

    public function clear()
    {
        $this->reset(['startDate', 'endDate', 'user_id', 'isSearched', 'commission']);
    }
}
