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

    public function getAll(){
        return $this->model->select(['id', 'name', 'brand','description', 'unit_price', 'package_price', 'invima_registration', 'strength', 'unit'])->get()->toArray();
    }

    public function show($productId){
        return $this->model->select(['id', 'name', 'brand','description', 'unit_price', 'package_price', 'invima_registration', 'strength', 'unit'])
        ->find($productId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        try{ 
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
            DB::beginTransaction(); 
                Product::updateOrcreate(['id' => $id], $productData);
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
            throw $e;
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}