<?php 
namespace App\Services;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException as ValidationValidationException;


Class UserService{
    
    public function __construct(
        protected User $model
    ){}

    public function show(User $user){
        return $user->toArray();
    }

    public function showUserActive($request){
        // return $request->user();
        $userId = $request->user()->id;

        $userData = User::select(['id','name','email', 'user_creator', 'user_role', 'user_job_title'])
            ->withWhereHas('user_role:id,name')
            ->withWhereHas('user_job_title:id,name')
            ->find($userId);
        return $userData;
    }

    public function getAll(){
        return $this->model->select(['id','name','email', 'user_creator', 'user_role', 'user_job_title'])
        ->with(['user_role:id,name','user_job_title:id,name'])->get()->toArray(); 
    }

    public function create(array $data){
        try{
            DB::beginTransaction(); //Iniciamos transacción. 
            $response = $this->model->create($data);
            DB::commit();
            return $response;
        }catch(QueryException $e){
            DB::rollBack();
            throw $e; //Retornamos error de consulta;
        }catch(Exception $e){
            DB::rollback();
            throw $e; //Retornamos error generico;
        }

    }

    public function login(array $data){
        if(!Auth::attempt($data)){
            throw ValidationValidationException::withMessages([
                'message' => ['Las credenciales son incorrectas']
            ]);
        }
        return true;
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}