<?php
namespace App\Services;

use App\Models\JobTitle;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

Class JobTitleService{

    public function __construct(
        protected JobTitle $model
    ){}


    public function getAll(){
        return $this->model->all()->select(['id', 'code', 'name', 'description'])->toArray();
    }
    
    public function show(int $jobTitleId){
        return $this->model->select(['id','code', 'name','description'])->find($jobTitleId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        try{   
            $jobTitleData = [
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description']
            ];

            DB::beginTransaction();
            JobTitle::updateOrcreate(['id' => $id], $jobTitleData);
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