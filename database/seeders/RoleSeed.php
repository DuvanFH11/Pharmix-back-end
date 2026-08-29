<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'code' => 'DEV',
            'name' => 'Desarrollador de software',
            'description' => 'El rol desarrollador interactua con todo el sistema sin restricción'
        ]);
    }
}
