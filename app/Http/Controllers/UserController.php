<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        protected UserService $service
    ){}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $response = $this->service->getAll();
            return $this->handleResponse(true, 'Se cargaron los usuarios correctamente', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Error al conectar con la base de datos', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, "Error inesperado del servidor",500,null,$e->getMessage(), "SERVER_ERROR");
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try{
            $response = $this->service->create($request->validated());
            return $this->handleResponse(true, 'Se ha creado el usuario correctamente', 201, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Error al crear el usuario', 500, null ,$e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'Error inesperado del servidor', 500, null , $e->getMessage(), "SERVER_ERROR");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->service->show($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(LoginRequest $request)
    {
        try{
            $this->service->login($request->validated());
            return $this->handleResponse(true, 'Inicio de sesión exitoso', 200);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'No fue posible iniciar sesión', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'Credenciales incorrectas', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }

    public function logout(Request $request){
        try{
            $this->service->logout($request);
            return $this->handleResponse(true, 'Sesión cerrada correctamente', 200, null);
        }catch(Exception $e){
            return $this->handleResponse(false, 'Error inesperado del servidor', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }
}
