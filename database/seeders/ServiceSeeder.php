<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Services\CalculateTotalProductCostService;
use App\Services\CommissionCalculatorService;
use App\Services\CostValueProductService;
use App\Services\HomeValueCalculatorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criação de serviços
        $service1 = Service::create([
            'name' => 'Corte de Cabelo',
            'description' => 'Corte de cabelo masculino',
            'price' => 300.00,
        ]);

        $service2 = Service::create([
            'name' => 'Hidratação',
            'description' => 'Tratamento hidratante para cabelos',
            'price' => 50.00,
        ]);

        $shampoo = Product::where('name', 'Shampoo')->first();
        $costPrice = CostValueProductService::costValueCalculator($shampoo->id, 100);

        $service1->products()->attach($shampoo->id, [
            'used_quantity' => 100,
            'cost_price' => $costPrice
        ]);

        $service2->products()->attach(
            $shampoo->id,
            [
                'used_quantity' => 200,
                'cost_price' => $costPrice
            ]
        );
    }
}
