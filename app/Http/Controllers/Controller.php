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
    ){
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ],$state);    
    }
}
