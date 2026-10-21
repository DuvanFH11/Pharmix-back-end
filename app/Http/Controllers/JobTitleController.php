<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleRequest;
use App\Models\JobTitle;
use App\Services\JobTitleService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    //Instancia del servicio de Cargos
    public function __construct(
        protected JobTitleService $service
    ){}
    //Método para mostrar todos los registros
    public function index(Request $request){
        $response = $this->service->getAll($request->query('code'));
        return $this->handleResponse(true, 'Se cargaron los cargos correctamente', 200, $response);
    }
    //Método para mostrar un registro
    public function show(int $jobTitleId){
        $response = $this->service->show($jobTitleId);
        return $this->handleResponse(true, "Se cargó el cargo correctamente", 200, $response);   
    }
    //Método para crear o actualizar un registro
    public function storeOrUpdate(JobTitleRequest $jobTitleRequest, ?int $id = null){
        $this->service->storeOrUpdate($jobTitleRequest, $id);
        return $this->handleResponse(true, 'Datos guardados correctamente', 200, null);
    }
    //Método para editar ciertos campos de un registro
    public function edit(JobTitle $jobTitle){
        //
    }
    //Método para eliminar o desactivar un registro
    public function destroy(JobTitle $jobTitle){
        //
    }
}
