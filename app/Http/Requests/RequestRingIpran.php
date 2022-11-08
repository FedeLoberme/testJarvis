<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRingIpran extends FormRequest
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
            'nodo' => 'required',
            'lsw' => 'required',
            'commen' => 'max:255',
            'dedica' => 'required',
            'type' => 'required',
            'port' => 'required',
            'ipran_acro' => 'required',
            'vlan_all' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'nodo'=> 'Nodo',
            'lsw'=> 'LSW Ipran',
            'commen'=> 'Comentario',
            'dedica'=> 'Dedicado',
            'type'=> 'Tipo de anillo',
            'ipran_acro'=> 'Acronimo',
            'port'=> 'Puerto',
            'vlan_all'=> 'Vlan de Gestión',
        ];
    }
}
