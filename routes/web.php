<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\DashboardComponent;
use App\Livewire\Expenses\ExpensesComponent;
use App\Livewire\Expenses\ExpensesFormComponent;
use App\Livewire\Expenses\ExpensesShowComponent;
use App\Livewire\Inventory\InventoryComponent;
use App\Livewire\Inventory\InventoryFormComponent;
use App\Livewire\Inventory\InventoryShowComponent;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductFormComponent;
use App\Livewire\Report\ReportCashComponent;
use App\Livewire\Report\ReportCommissionComponent;
use App\Livewire\Report\ReportComponent;
use App\Livewire\Report\ReportSalesComponent;
use App\Livewire\Report\ReportServiceComponent;
use App\Livewire\Sale\SaleComponent;
use App\Livewire\Sale\SaleFormComponent;
use App\Livewire\Sale\SaleShowComponent;
use App\Livewire\Schedule\ScheduleComponent;
use App\Livewire\Schedule\ScheduleFormComponent;
use App\Livewire\Schedule\ScheduleShowComponent;
use App\Livewire\Service\ServiceComponent;
use App\Livewire\Service\ServiceFormComponent;
use App\Livewire\Service\ServiceSellComponent;
use App\Livewire\Service\ServiceShowComponent;
use App\Livewire\Settings\SettingsComponent;
use App\Livewire\User\UserComponent;
use App\Livewire\User\UserCreateComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redireciona para o Dashboard se autenticado, caso contrário para o Login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Grupo de rotas protegidas pelo middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard');
    // User routes
    Route::get('/users', UserComponent::class)->name('users');
    Route::get('/users-create', UserCreateComponent::class)->name('users.form');
    Route::get('/users/{user}/edit', UserCreateComponent::class)->name('users.edit');

    // Product routes
    Route::get('/products', ProductComponent::class)->name('products');
    Route::get('/products-create', ProductFormComponent::class)->name('products.form');
    Route::get('/products/{product}/edit', ProductFormComponent::class)->name('products.edit');


    // Inventory routes
    Route::get('/inventories', InventoryComponent::class)->name('inventories');
    Route::get('/inventories/create', InventoryFormComponent::class)->name('inventories.create');
    Route::get('/inventories/{inventory}/edit', InventoryFormComponent::class)->name('inventories.edit');
    Route::get('/inventory/{inventory}/show', InventoryShowComponent::class)->name('inventories.show');

    // Service routes
    Route::get('/services', ServiceComponent::class)->name('services');
    Route::get('/services-create', ServiceFormComponent::class)->name('services.form');
    Route::get('/services/{service}/show', ServiceShowComponent::class)->name('services.show');
    Route::get('/services/{service}/edit', ServiceFormComponent::class)->name('services.edit');
    Route::get('/services-sell', ServiceSellComponent::class)->name('services.sell');

    // Schedules routes
    Route::get('/schedules', ScheduleComponent::class)->name('schedules');
    Route::get('/schedules-create', ScheduleFormComponent::class)->name('schedules.form');
    Route::get('/schedules/{schedule}/show', ScheduleShowComponent::class)->name('schedules.show');
    Route::get('/schedules/{schedule}/edit', ScheduleFormComponent::class)->name('schedules.edit');

    // Sales routes
    Route::get('/sales', SaleComponent::class)->name('sales');
    Route::get('/sales-create', SaleFormComponent::class)->name('sales.form');
    Route::get('/sales/{sale}/show', SaleShowComponent::class)->name('sales.show');
    Route::get('/sales/{sale}/edit', SaleFormComponent::class)->name('sales.edit');

    // Reports routes
    Route::get('/reports', ReportComponent::class)->name('reports');
    Route::get('/reports/services', ReportServiceComponent::class)->name('reports.services');
    Route::get('/reports/sales', ReportSalesComponent::class)->name('reports.sales');
    Route::get('/reports/commission', ReportCommissionComponent::class)->name('reports.commission');
    Route::get('/reports/cash', ReportCashComponent::class)->name('reports.cash');

    // Expenses routes
    Route::get('/expenses', ExpensesComponent::class)->name('expenses');
    Route::get('/expenses-create', ExpensesFormComponent::class)->name('expenses.form');
    Route::get('/expenses/{expense}/show', ExpensesShowComponent::class)->name('expenses.show');
    Route::get('/expenses/{expense}/edit', ExpensesFormComponent::class)->name('expenses.edit');

    // Settings routes
    Route::get('/settings', SettingsComponent::class)->name('settings');
});

// Rota pública de Login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');

Route::fallback(function () {
    return view('404');
});
