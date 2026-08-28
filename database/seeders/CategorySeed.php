<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        Siempre que se cree una categoría con su respectiva migración, crear un nuevo registro en esta seed haciendo 
        relación en el campo "table_name" al nombre de la tabla correspondiente.
        */
        Categories::create(
            [
                'name' => 'Usuarios',
                'path' => 'users_page',
                'table_name' => 'users'
            ],
            [
                'name' => 'Productos',
                'path' => 'products_page',
                'table_name' => 'products'
            ],
            [
                'name' => 'Roles',
                'path' => 'roles_page',
                'table_name' => 'roles'
            ],
            [
                'name' => 'Cargos',
                'path' => 'appointments_page',
                'table_name' => 'appointments'
            ],
            
            /*Estas son las categorías que se tienen en mente para integrar en el desarrollo. 
            [
                'name' => 'Pedidos',
                'path' => 'orders_page',
                'table_name' => 'orders'
            ],
            [
                'name' => 'Facturas',
                'path' => 'factures_page',
                'table_name' => 'factures'
            ],
            [
                'name' => 'Clientes',
                'path' => 'clients_page',
                'table_name' => 'clients'
            ],
            [
                'name' => 'Proveedores',
                'path' => 'providers_page',
                'table_name' => 'providers'
            ]
            */
        );
    }
}
