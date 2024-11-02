<?php

namespace App\Livewire\Report;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Relatórios')]
class ReportComponent extends Component
{
    public function render()
    {
        return view('livewire.report.report-component');
    }
}
