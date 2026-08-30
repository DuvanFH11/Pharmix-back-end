<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RoleSeed::class,
            AppointmentSeed::class,
            UserSeed::class,
            CategorySeed::class //Siempre después de todas las entidades/categorías que sean cruds;
        ]);
    }
}
