<?php 
namespace App\Services;

use App\Models\Categories;

Class CategoryService{
    public function __construct(
        protected Categories $model
    ){}


    public function getAll(){
        return $this->model->all()->toArray();
    }

    public function create(){

    }
}

