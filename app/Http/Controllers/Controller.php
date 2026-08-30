<?php

namespace App\Http\Controllers;

use BcMath\Number;
use Exception;
use Illuminate\Database\QueryException;

abstract class Controller
{
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
