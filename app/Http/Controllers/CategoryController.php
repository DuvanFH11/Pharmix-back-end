<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Requests\CategoriesRequest;
use App\Services\CategoryService;
use Exception;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected CategoryService $service
    ){}

    public function index()
    {  
        try{
            $response = $this->service->getAll();
            return $this->handleResponse(true, 'Listado de categorías cargado con exito', 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, 'Error al cargar las categorías',500,null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, 'Error interno del servidor', 500, null, $e->getMessage(),"SERVER_ERROR");
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
    // public function store(StoreCategoriesRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCategoriesRequest $request, Categories $categories)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        //
    }
}
