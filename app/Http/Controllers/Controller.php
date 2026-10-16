<?php

namespace App\Http\Controllers;

use BcMath\Number;
use Exception;
use Illuminate\Database\QueryException;

abstract class Controller
{
    protected array $messages = [
        //MENSAJES PARA CONSULTAS POST
            '001' => 'Datos guardados correctamente',
            '002' => 'Datos actualizados correctamente', 
              
        //MENSAJES PARA SESIÓN
            //EXITO
            '101' => 'El inicio de sesión fue exitoso',
            '102' => 'La sesión fue cerrada correctamente',
            //ADVERTENCIA
            '111' => 'La sesión ha expirado, vuelva a iniciarla por favor',
            //ERROR
            '121' => 'Las credenciales son incorrectas, vuelva a intentarlo',

        //ERROR DE CONSULTAS SQL // MYSQL Y POSGRE SQL
            '1062' => 'El registro ya existe en el sistema (Dato duplicado).',
            '1452' => 'El elemento de referencia (Rol, Cargo, etc.) seleccionado no es válido o no existe.',
            '1451' => 'No se puede eliminar este registro porque tiene otros datos asociados.',
            '1048' => 'No puedes dejar vacíos los campos obligatorios.',
            '1406' => 'Uno de los campos excede el límite de caracteres permitido.',
            '1364' => 'Falta un campo obligatorio requerido por el sistema.',
            '3819' => 'Uno de los valores ingresados no cumple con las reglas del sistema.',
        
        //ERROR DE SERVIDOR
        '500' => 'Lo sentimos, hay un error inesperado en el servidor, estamos trabajando en ello.',
    ];

    protected function handleResponse(
        bool $success ,
        string $message , 
        int $state, 
        ?array $data = null,
        ?string $exception = null,
        ?string $error_code = null,
    ){
        if($exception && $error_code){
            return response()->json([
                'success' => $success,
                'message' => $message,
                'exception' => $exception,
                'error_code' => $error_code                
            ],$state);
            
        }else{
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ],$state);
        }
    }
}
