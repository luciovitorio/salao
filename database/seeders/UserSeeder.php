<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Lucio Vitorio',
            'username' => 'luciovitorio',
            'email' => 'lucio@email.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Funcionário01',
            'username' => 'funcionario01',
            'email' => 'funcionario01@email.com',
            'password' => Hash::make('12345'),
            'commission' => 40,
            'role' => 'func',
        ]);
    }
}
