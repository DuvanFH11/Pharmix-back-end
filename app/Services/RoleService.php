<?php
namespace App\Services;

use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

Class RoleService{
    public function __construct(
        protected Role $model
    ){}

    public function getAll($roleCode, $page){
        $query =  $this->model->select(['id','code','name', 'description'])
        ->when($roleCode, function($query, $roleCode){
            return $query->where('code', 'LIKE', '%'.$roleCode.'%');
        });
        if($page){
            $roles = $query->paginate(4);
            return([
                "data" => $roles->items(),
                "total" => $roles->lastPage(),
                "per_page" => $roles->perPage(),
                "page" => $roles->currentPage()
            ]);
        }else{
            $allRoles = $query->get();
            return([
                "data" => $allRoles,
                "total" => $allRoles->count(),
                "per_page" => null,
                "page" => null
            ]);
        }
    }

    public function show(int $roleId){
        return $this->model->select(['id','code','name', 'description'])->find($roleId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        $roleData = [
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description']
        ];
        return DB::transaction(function() use($id, $roleData){
            return Role::updateOrCreate(['id' => $id ], $roleData);
        });
    }
}