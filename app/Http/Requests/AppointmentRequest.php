<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class AppointmentRequest extends FormRequest
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
            'code' => 'required|string|min:3|max:6',
            'name' => 'required|string|min:5|max:50',
            'description' => 'required|min:5|max:250',
        ];
    }
    #[Override]
    public function messages()
    {
        return [
            //Mensajes para el código del cargo;
            'code.required' => 'El código del cargo es obligatorio',
            'code.min' => 'El código del cargo debe tener como mínimo 3 carácteres',
            'code.max' => 'El código del cargo debe tener como máximo 5 carácteres',
            //Mensajes para el nombre del cargo;
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener como mínimo 5 carácteres',
            'name.max' => 'El nombre debe tener como máximo 50 carácteres',
            //Mensajes para la descripción del cargo;
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener como mínimo 5 carácteres',
            'description.max' => 'La descripción debe tener como máximo 250 carácteres'
        ];
    }
}
