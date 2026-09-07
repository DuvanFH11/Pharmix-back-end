<?php
namespace App\Services;

use App\Models\Role;

Class RoleService{
    public function __construct(
        protected Role $model
    ){}

    public function getAll(){
        return $this->model->all()->toArray();
    }
}