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
    public function store(JobTitleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JobTitle $jobTitle)
    {
        //
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
