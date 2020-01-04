<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nombres' => 'required',
            'apellidos' => 'required',
            'cedula' => 'required|unique:client',
            'correo' => 'required|unique:client',
            'telefono' => 'required',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombres.required' => 'el campo nombres es obligatorio!',
            'apellidos.required' => 'el campo apellidos es obligatorio!',
            'cedula.required' => 'el campo cedula es obligatorio!',
            'correo.required' => 'el campo correo es obligatorio!',
            'telefono.required' => 'el campo telefono es obligatorio!',
        ];
    }
}
