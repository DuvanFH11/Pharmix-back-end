<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $response = $this->service->getAll();
            return $this->handleResponse(true, "Se cargaron los productos correctamente", 200, $response);
        }catch(QueryException $e){
            return $this->handleResponse(false, "Error al conectar con la base de datos", 500, null, $e->getMessage(), "DATABASE_ERROR");
        }catch(Exception $e){
            return $this->handleResponse(false, "Error inesperado del servidor", 500, null, $e->getMessage(), "SERVER_ERROR");
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
    public function store(ProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
