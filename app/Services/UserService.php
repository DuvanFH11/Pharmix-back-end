<?php 
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;


Class UserService{
    
    public function __construct(
        protected User $model
    ){}

    public function show($request){
        return $request->user();
    }

    public function create(array $data){
        return $this->model->create($data);
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