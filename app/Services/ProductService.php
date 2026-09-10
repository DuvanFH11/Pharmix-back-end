<?php
namespace App\Services;

use App\Models\Product;

Class ProductService{
    public function __construct(
        protected Product $model
    ){}

    public function getAll(){
        return $this->model->select(['id', 'name', 'brand','description', 'unit_price', 'package_price', 'invima_registration', 'strength', 'unit', 'user_creator'])
        ->with(['user_creator:id, name'])->get()->toArray();
    }
}