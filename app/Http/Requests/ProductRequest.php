<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'brand' => 'required|string|min:5|max:50',
            'description' => 'required|min:5',
            'unit_price' => 'required|numeric',
            'package_price' => 'required|numeric',
            'invima_registration' => 'required|string',
            'is_active' => 'required|boolean',
            'strength' =>  'required|numeric',
            'unit' => 'required|string'
        ];
    }

    public function messages() : array {
        return [
            //Mesajes para el nombre del producto
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener como mínimo 5 carácteres',
            'name.max' => 'El nombre debe tener como máximo 50 carácteres',
            //Mensajes para la marca del producto
            'brand.required' => 'La marca es obligatoria',
            'brand.min' => 'La marca debe tener como mínimo 5 carácteres',
            'brand.max' => 'La marca debe tener como máximo 50 carácteres',
            //Mensajes para la descripción del producto
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener como mínimo 5 carácteres',
            //Mensajes para el precio del producto
            'unit_price.required' => 'El precio por unidad es obligatorio',
            'package_price.required' => 'El precio por paquete es obligatorio',
            //Mensajes para el pricipio activo del producto (Gramaje)
            'strength.required' => 'El principio activo es obligatorio',
            //Mensajes para la unidad de medida del pricipio activo
            'unit.required' => 'La unidad de medida es obligatoria',
            'unit.min' => 'La unidad de medida debe tener como mínimo 5 carácteres',
            'unit.max' => 'La unidad de medida debe tener como máximo 50 carácteres'
        ];
    }
}
