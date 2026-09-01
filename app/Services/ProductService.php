<?php
namespace App\Services;

use App\Models\Product;

Class ProductService{
    public function __construct(
        protected Product $model
    ){}

    public function getAll(){
        return $this->model->with(['user_creator:id, name'])->get()->toArray();
    }
}