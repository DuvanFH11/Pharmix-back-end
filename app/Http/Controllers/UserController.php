<?php

namespace App\Http\Controllers;

use App\Exceptions\ExpiredCodeException;
use App\Exceptions\InvalidCodeException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*Instanciamos el servicio para poder usarlo en los métodos*/ 
    public function __construct(
        protected UserService $service
    ){}
    
    /*Método para sacar la información del usuario que tiene sesión iniciada*/
    public function showUser(Request $request){
        return $this->service->showUserActive($request);
    }
    /* Método para sacar todos los registro de la tabla usuarios*/
    public function index(Request $request)
    {
        try{
            $response = $this->service->getAll($request->query('email'), $request->query('page'));
            return $this->handleResponse(true, 'Se cargaron los usuarios correctamente', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'El sistema no está disponible temporalmente, intentalo más tarde.', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }
    /*Método para consultar para crear o actualizar un registro*/
    public function storeOrUpdate(UserRequest $userRequest, ?Int $userId = null){
        try{
            $response = $this->service->storeOrUpdate($userRequest, $userId);
            return $this->handleResponse(true, 'Datos guardados correctamente',200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'El sistema no está disponible temporalmente, intentalo más tarde.', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }

    /*Método para sacar el registro de cualquier usuario por su Id*/
    public function show(Int $userId)
    {
        try{
            $response = $this->service->show($userId);
            return $this->handleResponse(true, 'Usuario cargado correctamente', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'El sistema no está disponible temporalmente, intentalo más tarde.', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
        // return $this->service->show($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    /*Método para enviar código por correo al usuario*/
    public function sendCode(String $email){
        try{
            $response = $this->service->sendCode($email);
            return $this->handleResponse(true, "Se envió el correo correctamente", 200, null);
        }catch(QueryException $e){ 
            return $this->handleResponse(false, "Ocurrió un error al hacer el envío del código, intentelo de nuevo por favor", 500, null, $e->getMessage_(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, "Ocurrió un error inesperado en el servidor, lo sentimos", 500, null, $e->getMessage(), "SERVER_ERROR");
        }        
    }

    /*Método para verificar código por correo al usuario*/
    public function verifyCode(String $email, Int $userInputCode){
        try{
            $response = $this->service->verifyCode($email, $userInputCode);
            return $this->handleResponse(true, "La validación del código fue correcta.", 200, null);
        }catch(InvalidCodeException $e){
            return $this->handleResponse(false,"El código es incorrecto, vuelve a ingresarlo o solicita otro.", 500, null, $e->getMessage(), "SERVER_ERROR");
        }catch(ExpiredCodeException $e){
            return $this->handleResponse(false,"El código ha expirado, por favor solicita otro", 500, null, $e->getMessage(), "SERVER_ERRROR");
        }
    }
    /*Método para gestionar el login del usuario*/
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
    /*Método para gestionar el cierre de sesión del usuario*/
    public function logout(Request $request){
        try{
            $this->service->logout($request);
            return $this->handleResponse(true, 'Sesión cerrada correctamente', 200, null);
        }catch(Exception $e){
            return $this->handleResponse(false, 'Error inesperado del servidor', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }
}
