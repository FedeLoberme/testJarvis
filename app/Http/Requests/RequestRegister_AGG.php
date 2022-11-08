<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegister_AGG extends FormRequest
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
            'id'=>'required',
            'nodo_al'=>'required|max:10',
            'alta'=>'required|regex:/[0-9a-zA-Z]{2,10}/|max:10',
            'name'=>'required|max:20',
            'acronimo'=>'required|max:20',
            'ip_admin'=>'required|regex:/[0-9]/|max:10',
            'local'=>'max:50',
            'commen'=>'max:255',
            'equi_alta'=>'required|regex:/[0-9]/|max:10',
            'port'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'id',
            'name' => 'Acronimo',
            'acronimo' => 'Acronimo de Anillo',
            'alta'=> 'IR Alta',
            'ip_admin'=> 'IP de Gestión',
            'local'=> 'Localización',
            'commen'=> 'Comentario',
            'equi_alta'=> 'Modelo',
            'port'=> 'Placa',
            'nodo_al'=> 'Nodo',
        ];
    }
}
