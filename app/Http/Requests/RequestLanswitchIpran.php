<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLanswitchIpran extends FormRequest
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
            'board'=>'required',
            'ip_admin'=>'required|regex:/[0-9]{1,10}/|max:10',
            'enlace'=>'required|regex:/[0-9a-zA-Z]{2,10}/|max:10',
            'orden'=>'required|regex:/[0-9a-zA-Z]{2,10}/|max:10',
            'name'=>'required|max:20',
            'commen'=>'max:255',
            'local'=>'max:50',
            'equi_alta'=>'required|regex:/[0-9]/|max:10',
            'sitio'=>'required|max:2|in:Si,No',
            'nodo_al'=>'required_if:sitio,No|max:10',
            'ring'=>'required_if:sitio,Si|max:10',
            'link'=>'required_if:sitio,No|max:10',
            'port'=>'required_if:sitio,No|max:10',
            'direc'=>'required_if:sitio,Si|max:10',
            'port_sar'=>'required_if:sitio,No|max:50',
            'equi_sar'=>'required_if:sitio,No|max:50',
            'client'=>'required_if:sitio,Si|max:10',
        ];
    }

    public function attributes()
    {
        return [
            'ip_admin'=> 'IP de Gestión',
            'enlace'=> 'N° Enlace',
            'orden'=> 'Orden',
            'sitio'=> 'Sitio Cliente',
            'client' => 'Cliente',
            'name' => 'Acronimo',
            'local'=> 'Localización',
            'nodo_al'=> 'Nodo',
            'direc'=> 'Dirección',
            'equi_alta'=> 'Modelo',
            'board'=> 'Placa',
            'commen'=> 'Comentario',
            'link'=> 'Link',
            'port_sar'=> 'Puerto Sar',
            'equi_sar'=> 'Equipo Sar',
            'ring'=> 'Anillo',
        ];
    }
}
