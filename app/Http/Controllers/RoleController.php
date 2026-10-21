<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //Instancia del servicio de Roles
    public function __construct(
        protected RoleService $service
    ){}
    //Método para consultar todos los roles
    public function index(Request $request){
        $response = $this->service->getAll($request->query('code'));
        return $this->handleResponse(true, 'Se cargaron los roles correctamente', 200, $response);
    }
    //Método para crear o actualizar un rol
    public function storeOrUpdate(RoleRequest $roleRequest, ?int $id = null){
        $this->service->storeOrUpdate($roleRequest, $id);
        return $this->handleResponse(true, "Datos guardados correctamente", 200, null);
    }
    //Método para consultar un rol en específico
    public function show(int $roleId){
        $response = $this->service->show($roleId);
        return $this->handleResponse(true, "Rol cargado con correctamente", 200, $response);
    }
    //Método para editar para actualizar ciertos valores de un rol
    public function edit(Role $roles)
    {
        //
    }
    //Método para eliminar o desactivar un rol
    public function destroy(Role $roles)
    {
        //
    }
}
