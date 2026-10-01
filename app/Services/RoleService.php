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

    public function getAll($roleCode){
        $roles =  $this->model->select(['id','code','name', 'description'])
        ->when($roleCode, function($query, $roleCode){
            return $query->where('code', 'LIKE', '%'.$roleCode.'%');
        })
        ->paginate(4);
        return([
            "data" => $roles->items(),
            "total" => $roles->total(),
            "per_page" => $roles->perPage(),
            "page" => $roles->currentPage()
        ]);
    }

    public function show(int $roleId){
        return $this->model->select(['id','code','name', 'description'])->find($roleId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        try{
            $roleData = [
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description']
            ];
            DB::begintransaction();
            Role::updateOrcreate(['id' => $id], $roleData);
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