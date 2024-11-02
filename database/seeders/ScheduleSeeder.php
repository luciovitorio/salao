<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::create([
            'user_id' => 1,
            'client_name' => 'Suzana',
            'service_name' => 'Corte',
            'schedule_date' => '2024-10-22',
            'schedule_time' => '14:30:00',
            'price' => 100
        ]);

        Schedule::create([
            'user_id' => 2,
            'client_name' => 'Monique',
            'service_name' => 'Hidratação',
            'schedule_date' => '2024-10-22',
            'schedule_time' => '14:30:00',
            'price' => 70
        ]);
    }
}
