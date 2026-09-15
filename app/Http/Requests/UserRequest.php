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
            'email' => 'required|email|',
            'user_job_title' => 'required|integer',
            'user_role' => 'required|integer',
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
            //Mensajes para el cargo del usuario;
            'user_job_title.required' => 'El cargo es obligatorio',
            //Mensajes para el rol del usuario;
            'user_rol.required' => 'El rol es obligatorio',
        ];
    }
}
