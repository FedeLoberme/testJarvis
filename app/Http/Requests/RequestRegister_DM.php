<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegister_DM extends FormRequest
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
            'alta'=>'required|regex:/[0-9a-zA-Z]{4,10}/|max:10',
            'name'=>'required|max:20',
            'ip_admin'=>'required|regex:/[0-9]/|max:10',
            'local'=>'max:50',
            'commen'=>'max:255',
            'equipo'=>'required|regex:/[0-9]/|max:10',
            'port'=>'required',
            'nodo'=>'required|max:10',
            'id_zone'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Acronimo',
            'alta'=> 'IR Alta',
            'ip_admin'=> 'IP de Gestión',
            'local'=> 'Localización',
            'commen'=> 'Comentario',
            'equipo'=> 'Modelo',
            'port'=> 'Placa',
            'nodo'=> 'Nodo',
            'id_zone'=> 'Zona',
        ];
    }
}
