<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Desarrollador Duván Florez',
            'email' => 'desarrollador@administrador.com',
            'password' => Hash::make('desarrollador123'),
            'age' => 19,
            
            'last_connection' => now(),
            
            'user_rol' => 1,
            'user_appointment' => 1,
        ]);
    }
}
