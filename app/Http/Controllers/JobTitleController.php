<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleRequest;
use App\Models\JobTitle;
use App\Services\JobTitleService;
use Exception;
use Illuminate\Database\QueryException;

class JobTitleController extends Controller
{
    public function __construct(
        protected JobTitleService $service
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $response = $this->service->getAll();
            return $this->handleResponse(true, 'Se cargaron los cargos correctamente', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.', 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'El sistema no está disponible temporalmente, intentalo más tarde.', 500, null, $e->getMessage(), "SERVER_ERROR");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $jobTitleId)
    {
        try{
            $response = $this->service->show($jobTitleId);
            return $this->handleResponse(true, "Se cargó el cargo correctamente", 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, "Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.", 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, "El sistema no está disponible temporalmente, intentalo más tarde.", 500, null, $e->getMessage(), "SERVER_ERROR");
        }   
    }

    public function storeOrUpdate(JobTitleRequest $jobTitleRequest, ?int $id = null){
        try{
            $response = $this->service->storeOrUpdate($jobTitleRequest, $id);
            return $this->handleResponse(true, "Datos guardados correctamente", 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, "Lo sentimos, algo salió mal al procesar la solicitud, vuelve a intentarlo.", 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, "El sistema no está disponible temporalmente, intentalo más tarde.", 500, null, $e->getMessage(),"SERVER_ERROR");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobTitle $jobTitle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobTitleRequest $request, JobTitle $jobTitle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobTitle $jobTitle)
    {
        //
    }
}
