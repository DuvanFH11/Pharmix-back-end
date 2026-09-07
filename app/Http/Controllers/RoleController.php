<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Exception;
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $service
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $response = $this->service->getAll();
            return $this->handleResponse(true, 'Se cargaron los roles correctamente', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Error al conectar con la base de datos', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'Error inesperado del servidor', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $roles)
    {
        //
    }
}
