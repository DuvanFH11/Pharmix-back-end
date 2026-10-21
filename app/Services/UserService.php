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
use Illuminate\Validation\ValidationException;

Class UserService{
    
    public function __construct(
        protected User $model
    ){}

    public function show(int $userId){
        return $this->model->select(['id', 'name', 'email', 'user_role', 'user_job_title'])->find($userId)->toArray();
    }

    public function showUserActive($request){
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
        return([
            'data' => $users->items(),
            'total' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'page' => $users->currentPage()
        ]);
    }
    public function storeOrUpdate($data,$id){
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'user_role' => $data['user_role'],
            'user_job_title' => $data['user_job_title']    
        ];
        if(!$id){
            $userData['password'] = $data['email'];
        }
        return DB::transaction(function() use($id, $userData){
            return User::updateOrcreate(['id' => $id], $userData);
        });
    }

    public function create(array $data){
        return DB::transaction(function() use($data){
            return $this->model->create($data);   
        });
    }
    public function modify( $id, $name, $email){
        $user = User::findOrFail($id);
        return $user->update([
            'name' => $name,
            'email' => $email
        ]);
    }
    public function changePass(Int $id , String $password){
        $user = User::findOrFail($id);
        
        return $user->update(['password' => $password]);
    }

    public function login(array $data){
        if(!Auth::attempt($data)){
            throw new ValidationException('Las credenciales son incorrectas');
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