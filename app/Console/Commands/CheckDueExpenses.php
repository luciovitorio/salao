<?php

namespace App\Console\Commands;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CheckDueExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-due-expenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica despesas com due_date para o dia atual e campo remember_me como true';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Consultar despesas com `remember_me` true e `due_date` igual a hoje
        $dueExpenses = Expense::where('remember_me', true)
            ->where('is_paid', false)
            ->whereDate('due_date', $today)
            ->get();

        // Armazenar o resultado no cache para o componente Livewire
        Cache::put('due_expenses_today', $dueExpenses, now()->addDay());

        $this->info("Despesas não pagas com due_date para hoje foram armazenadas no cache.");

        return 0;
    }
}
