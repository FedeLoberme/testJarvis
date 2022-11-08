<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegister_LS extends FormRequest
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
            'id'=>'required|regex:/[0-9]{1,10}/|max:10',
            'anilo'=>'required|regex:/[0-9]{1,10}/|max:10',
            'port'=>'required',
            'valor'=>'required',
            'ip_admin'=>'required|regex:/[0-9]{1,10}/|max:10',
            'enlace'=>'required|regex:/[0-9a-zA-Z]{2,10}/|max:10',
            'orden'=>'required|regex:/[0-9a-zA-Z]{2,10}/|max:10',
            'client'=>'required|regex:/[0-9]{1,10}/|max:10',
            'name'=>'required|max:20',
            'commen'=>'max:255',
            'local'=>'max:50',
            'equi_alta'=>'required|regex:/[0-9]/|max:10',
            'sitio'=>'required|max:2|in:Si,No',
            'nodo_al'=>'required_if:sitio,No|max:10',
            'direc'=>'required_if:sitio,Si|max:10',
        ];
    }

    public function attributes()
    {
        return [
            'anilo'=> 'Nodo',
            'ip_admin'=> 'IP de Gestión',
            'port'=> 'Puerto',
            'enlace'=> 'N° Enlace',
            'orden'=> 'Orden',
            'sitio'=> 'Sitio Cliente',
            'client' => 'Cliente',
            'name' => 'Acronimo',
            'local'=> 'Localización',
            'nodo_al'=> 'Nodo',
            'direc'=> 'Dirección',
            'equi_alta'=> 'Modelo',
            'valor'=> 'Placa',
            'commen'=> 'Comentario',
        ];
    }
}
