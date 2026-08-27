<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:10|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5',
            'age' => 'required|numeric',
            
            'last_connection' => 'required|timezone',
            
            'user_appointment' => 'required|string|min:5|max:50',
            'user_rol' => 'required|string|min:5|max:50',
        ];
    }
    public function messages()
    {
        return[
            //Mesajes para el nombre del usuario;
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener como mínimo 10 carácteres',
            'name.max' => 'El nombre debe tener como máximo 50 carácteres',
            //Mensajes para el email del usuario;
            'email.required' => 'El correo es obligatorio',
            'email.email' => 'El formato del correo no es válido',
            'email.unique' => 'El correo ya está asociado a una cuenta',
            //Mensajes para la password del usuario;
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 5 carácteres',
            //Mensajes para la edad del usuario;
            'age.required' => 'La edad es requerida',
            //Mensajes para el cargo del usuario;
            'user_appointment.required' => 'El cargo es obligatorio',
            'user_appointment.min' => 'El cargo debe tener como mínimo 5 carácteres',
            'user_appointment.max' => 'El cargo debe tener como máximos 50 carácteres',
            //Mensajes para el rol del usuario;
            'user_rol.required' => 'El rol es obligatorio',
            'user_rol.min' => 'El rol debe tener como mínimo 5 carácteres',
            'user_rol.max' => 'El rol debe tener como máximo 50 carácteres',
        ];
    }
}
