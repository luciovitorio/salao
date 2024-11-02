<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inventory::create([
        //     'product_id' => 1,
        //     'quantity' => 10,
        //     'entry_date' => Carbon::create(2024, 10, 22),
        //     'unit_price' => 2.00,
        //     'total_cost' => 20.00,
        // ]);

        // Inventory::create([
        //     'product_id' => 2,
        //     'quantity' => 40,
        //     'entry_date' => Carbon::create(2024, 10, 22),
        //     'unit_price' => 4.00,
        //     'total_cost' => 160.00,
        // ]);
    }
}
