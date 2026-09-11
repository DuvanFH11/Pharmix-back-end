<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTitleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobTitle::create([
            'code' => 'DEV',
            'name' => 'Desarrollador',
            'description' => 'Desarrollador de software',
        ]);
    }
}
