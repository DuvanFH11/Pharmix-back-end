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

    public function show($request){
        return $request->user();
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