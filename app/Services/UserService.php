<?php 
namespace App\Services;

use App\Exceptions\DuplicateCodeException;
use App\Exceptions\ExpiredCodeException;
use App\Exceptions\InvalidCodeException;
use App\Mail\SendCodeValidationMail;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

Class UserService{
    
    public function __construct(
        protected User $model
    ){}

    public function show(int $userId){
        return $this->model->select(['id', 'name', 'email', 'user_role', 'user_job_title'])->find($userId)->toArray();
    }

    public function showUserActive($request){
        // return $request->user();
        $userId = $request->user()->id;

        $userData = User::select(['id','name','email', 'user_role', 'user_job_title'])
            ->withWhereHas('user_role:id,name')
            ->withWhereHas('user_job_title:id,name')
            ->find($userId);
        return $userData;
    }

    public function getAll($userEmail, $page){
        
        $users = $this->model->select(['id','name','email', 'user_role', 'user_job_title'])
        ->with(['user_role:id,name','user_job_title:id,name'])
        ->when($userEmail, function ($query, $userEmail){
            return $query->where('email', 'LIKE', '%'.$userEmail.'%');
        })
        ->paginate(4, ['*'], 'page', $page);
        // dd($users);
        return([
            'data' => $users->items(),
            'total' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'page' => $users->currentPage()
        ]);
    }
    public function storeOrUpdate($data,$id){
        try{
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'user_role' => $data['user_role'],
                'user_job_title' => $data['user_job_title']    
            ];
            if(!$id){
                $userData['password'] = $data['email'];
            }

            DB::beginTransaction();
            User::updateOrCreate(['id' => $id],$userData);
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
            throw $e;
        }catch(QueryException $e){
            DB::rollBack();
            throw $e;
        }

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
    public function modify( $id, $name, $email){
        try{
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->name = $name;
            $user->email = $email;
            $user->save();
            DB::commit();
            return true;
        }catch(QueryException $e){
            DB::rollBack();
            throw $e;
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
    public function changePass(Int $id , String $password){
        try{
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->password = $password;
            $user->save();
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }catch(Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    public function login(array $data){
        if(!Auth::attempt($data)){
            throw new \Exception('Unauthorized', 401);
        }
        return true;
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function sendCode($email){
        if(empty(Cache::get("validation_code_{$email}"))){
            $code = rand(1000, 9999);
            try{
                Mail::to($email)->send(new SendCodeValidationMail($code));
                Cache::put("validation_code_{$email}", $code, now()->addMinutes(1));
                return true;    
            }catch(Exception $e){
                throw new \Exception($e->getMessage());
            }
        }else{
            throw new DuplicateCodeException('Hay un código activo actualmente');
        }
    }

    public function verifyCode($email, $userInputCode){
        $savedCode = Cache::get("validation_code_{$email}");
        if(!$savedCode){
            throw new ExpiredCodeException("El código ha expirado, solicite otro por favor");
        }
        if((int)$savedCode !== $userInputCode){
            throw new InvalidCodeException("El código ingresado no es válido, ingreselo nuevamente o solicite otro.");
        }

        Cache::forget("validation_code_{$email}");
        return true;
    }

}