<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegister_CPE extends FormRequest
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
            'client'=>'required|max:10',
            'rpv'=>'required|max:2|in:Si,No',
            'sitio'=>'required|max:2',
            'management'=>'required|max:2',
            'name'=>'required|max:20',
            'alta'=>'required|regex:/[0-9a-zA-Z]{4,10}/|max:10',
            'enlace'=>'required|regex:/[0-9]{1,20}/|max:20',
            'local'=>'max:255',
            'equi_alta'=>'required|regex:/[0-9]/|max:10',
            'port'=>'required',
            'commen'=>'max:255',
            'ip_wan'=>'required_if:rpv,Si|max:15',
            'ip_admin'=>'required_if:rpv,No|max:10',
            'nodo_al'=>'required_if:sitio,No|max:10',
            'direc'=>'required_if:sitio,Si|max:10',
        ];
    }

    public function attributes()
    {
        return [
            'client' => 'Cliente',
            'rpv' => 'RPV',
            'sitio' => 'Sitio Cliente',
            'management' => 'Gestión Cliente',
            'name' => 'Acronimo',
            'alta'=> 'IR OS ALTA',
            'enlace'=> 'N° Enlace',
            'ip_admin'=> 'IP WAN',
            'ip_wan'=> 'IP WAN RPV',
            'nodo_al'=> 'Nodo',
            'direc'=> 'Dirección',
            'local'=> 'Localización',
            'commen'=> 'Comentario',
            'equi_alta'=> 'Modelo',
            'port'=> 'Placa',
        ];
    }
}
