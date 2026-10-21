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


    public function getAll($jobTitleCode){
        $jobTitles = $this->model->select(['id', 'code', 'name', 'description'])
        ->when($jobTitleCode, function($query, $jobTitleCode){
            return $query->where('code', 'LIKE', '%'. $jobTitleCode .'%');
        })
        ->paginate(4);

        return([
            "data" => $jobTitles->items(),
            "total" => $jobTitles->lastPage(),
            "per_page" => $jobTitles->perPage(),
            "page" => $jobTitles->currentPage()
        ]);
    }
    
    public function show(int $jobTitleId){
        return $this->model->select(['id','code', 'name','description'])->find($jobTitleId)->toArray();
    }

    public function storeOrUpdate($data, $id){
        $jobTitleData = [
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description']
        ];
        return DB::transaction(function() use($id,$jobTitleData){
            return JobTitle::updateOrcreate(['id' => $id], $jobTitleData);
        });
    }
}