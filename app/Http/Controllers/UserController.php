<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*Instanciamos el servicio para poder usarlo en los métodos*/ 
    public function __construct(
        protected UserService $service
    ){}
    //Método para consultar todos los usuarios
    public function index(Request $request){
        $response = $this->service->getAll($request->query('email'), $request->query('page'));
        return $this->handleResponse(true, 'Se cargaron los usuarios correctamente', 200, $response);
    }
    //Método para crear o modificar un usuario
    public function storeOrUpdate(UserRequest $userRequest, ?Int $userId = null){
        $this->service->storeOrUpdate($userRequest, $userId);
        return $this->handleResponse(true, 'Datos guardados correctamente',200, null);
    }
    //Método para consultar un usuario en específico
    public function show(Int $userId){
        $response = $this->service->show($userId);
        return $this->handleResponse(true, 'Usuario cargado correctamente', 200, $response);
    }
    //Método para sacar la información del usuario que tiene sesión iniciada
    public function showUser(Request $request){
        return $this->service->showUserActive($request);
    }
    //Método para actualizar ciertos valores de un usuario
    public function edit(string $id, Request $request){
        $this->service->modify($id, $request->input('name'), $request->input('email'));
        return $this->handleResponse(true, "Datos guardados correctamente", 200, null);
    }
    //Método para cambiar la contraseña del usuario
    public function changePass(Request $request, Int $userId){
        $this->service->changePass($userId, $request->input('newPass'));
        return $this->handleResponse(true, 'Contraseña modificada correctamente', 200, null);
    }
    //Método para eliminar o desactivar un usuario
    public function destroy(string $id){
        //
    }

    //Método para enviar código por correo al usuario
    public function sendCode(Request $request){
        $this->service->sendCode($request->input('email'));
        return $this->handleResponse(true, "Se envió el correo correctamente", 200, null);        
    }
    //Método para verificar código por correo al usuario
    public function verifyCode(Request $request){
        $this->service->verifyCode($request->input('email'), $request->input('code'));
        return $this->handleResponse(true, "La validación del código fue correcta.", 200, null);
    }
    //Método para gestionar el login del usuario
    public function login(LoginRequest $request){
        $this->service->login($request->validated());
        return $this->handleResponse(true, 'Inicio de sesión exitoso', 200);
    }
    //Método para gestionar el cierre de sesión del usuario
    public function logout(Request $request){
        $this->service->logout($request);
        return $this->handleResponse(true, 'Sesión cerrada correctamente', 200, null);
    }
}
