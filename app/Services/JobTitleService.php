<?php
namespace App\Services;

use App\Models\JobTitle;

Class JobTitleService{

    public function __construct(
        protected JobTitle $model
    ){}


    public function getAll(){
        return $this->model->all()->select(['id', 'code', 'name', 'description'])->toArray();
    }
}