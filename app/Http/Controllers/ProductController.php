<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Instancia del servicio de productos
    public function __construct(
        protected ProductService $service
    ){}
    //Método para consultar todos los productos
    public function index(Request $request)
    {
        $response = $this->service->getAll($request->query('value'));
        return $this->handleResponse(true, "Se cargaron los productos correctamente", 200, $response);
    }
    //Método para crear o modificar un producto
    public function storeOrUpdate(ProductRequest $productRequest, ?int $id = null){
        $this->service->storeOrUpdate($productRequest, $id);
        return $this->handleResponse(true, 'Datos guardados correctamente', 200, null);
    }
    //Método para consultar un producto en específico
    public function show(Int $productId){
        $response = $this->service->show($productId);
        return $this->handleResponse(true, 'Usuario cargado correctamente', 200, $response);
    }
    //Método para editar ciertos valores de un producto
    public function edit(Product $product)
    {
        //
    }
    //Método para eliminar o desactivar un producto
    public function destroy(Product $product)
    {
        //
    }
}
