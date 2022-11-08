<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestModule extends FormRequest
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
            'nombre'=>'max:50',
            'tipo'=>'max:10',
            'distancia'=>'max:8',
            'fibra'=>'max:10',
            'cortaLarga'=>'max:8',

        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'tipo'=> 'Tipo',
            'distancia'=> 'Distancia',
            'fibra' => 'Fibra',
            'cortaLarga'=> 'Corta Larga',
        ];
    }
}
