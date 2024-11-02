<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected $seeder = [
        SettingSeeder::class,
        UserSeeder::class,
        ProductSeeder::class,
        ServiceSeeder::class,
        EntrySeeder::class,
        ScheduleSeeder::class
    ];
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(EntrySeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
