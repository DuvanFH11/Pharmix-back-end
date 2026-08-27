<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginRequest extends FormRequest
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
            "email" => 'required|email',
            "password" => 'required|string|min:5'
        ];
    }

    public function messages()
    {
        return [
            "email.email" => "El formato del correo no es válido",
            "email.required" => "El correo es obligatorio",
            "password.required" => "La contraseña es obligatoria",
            "password.min" => "La contraseña debe tener mínimo 5 carácteres"
        ];
    }
}
