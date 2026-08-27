<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class RoleRequest extends FormRequest
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
            'name' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:5',
        ];
    }
    #[Override]
    public function messages()
    {
        return[
            //Mesajes para el nombre del rol;
            'name.required' => "El nombre es obligatorio",
            'name.min' =>   'El  nombre debe tener como mínimo 5 carácteres',
            'name.max' => 'El nombre debe tener como máximo 50 carácteres',
            //Mensajes para la descripción del rol;
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener como mínimo 5 carácteres'
        ];
    }
}
