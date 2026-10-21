<?php
namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class ProductService{
    public function __construct(
        protected Product $model
    ){}

    public function getAll($value){
        $products = $this->model->select(['id', 'name', 'brand','description', 'unit_price', 'package_price', 'invima_registration', 'strength', 'unit'])
         ->when($value, function($query, $value){
            return $query->where(function($subquery) use ($value) {
                $subquery->where('invima_registration', 'LIKE', '%'.$value.'%')
                        ->orWhere('name', 'LIKE', '%'.$value.'%');
            });
        })
        ->paginate(4);

        return ([
            "data" => $products->items(),
            "total" => $products->lastPage(),
            "per_page" => $products->perPage(),
            "page" => $products->currentPage()
        ]); 
    }

    public function show($productId){
        return $this->model->select(['id', 'name', 'brand','description', 'unit_price', 'package_price', 'invima_registration', 'strength', 'unit'])
        ->find($productId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        $productData = [
            'name' => $data['name'],
            'brand' => $data['brand'],
            'description' => $data['description'],
            'package_price' => $data['package_price'],
            'unit_price' => $data['unit_price'],
            'invima_registration' => $data['invima_registration'],
            'strength' => $data['strength'],
            'unit' => $data['unit']
        ];
        return DB::transaction(function() use($id, $productData){
            return Product::updateOrCreate(['id' => $id], $productData);
        });
    }
}