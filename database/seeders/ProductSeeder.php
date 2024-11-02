<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Shampoo',
            'category' => 'cuidados capilares',
            'qtd_stock' => 1000.0,
            'qtd_min' => 300,
            'cost_price' => 300,
            'sale_price' => 350,
            'unit_type' => 'ml',
            'quantity' => 1000,
            'qtd_service' => 20,
            'cost_per_service' => 300 / 20,
            'qtd_used_per_service' => 1000 / 20
        ]);

        Product::create([
            'name' => 'Sabonete',
            'category' => 'higiene',
            'qtd_stock' => 5.0,
            'qtd_min' => 2,
            'cost_price' => 5.00,
            'sale_price' => 10.5,
            'unit_type' => 'un',
            'quantity' => 1,
            'qtd_service' => 2,
            'cost_per_service' => 5 / 2,
            'qtd_used_per_service' => 1 / 2
        ]);
    }
}
