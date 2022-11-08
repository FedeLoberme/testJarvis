<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRadio extends FormRequest
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
            'lsw' => 'required',
            'port_datos' => 'required',
            'port_gestion' => 'max:10',
            'nodo' => 'required',
            'radio' => 'max:10',
            'modelo' => 'required',
            'acro_radio' => 'required',
            'ip_admin' => 'required',
            'ip_loopback' => 'max:10',
            'neid' => 'max:50',
            'frecuencia' => 'required',
            'antena' => 'required',
            'port_radio' => 'required',
            'servicio' => 'required',
            'orden' => 'required',
            'client' => 'required',
            'address' => 'required',
            'modelo2' => 'required',
            'radio_acro' => 'required',
            'ne_id_radio' => 'max:50',
            'loopback_ip' => 'max:10',
            'id_frecuencia' => 'required',
            'id_antena' => 'required',
            'new_port' => 'required',
            'port_radio_if' => 'required',
            'port_radio2_if' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'lsw' => 'Equipo LSW',
            'port_datos' => 'Puerto LSW DATOS',
            'port_gestion' => 'Puerto LSW Gestion',
            'nodo' => 'Nodo',
            'radio' => 'Radio',
            'modelo' => 'Modelo de Radio 1',
            'acro_radio' => 'Acronimo Radio 1',
            'ip_admin' => 'IP de Gestión Radio 1',
            'ip_loopback' => 'IP LoopBack Radio 1',
            'neid' => 'NE-ID Radio 1',
            'frecuencia' => 'Frecuencia (ODU) Radio 1',
            'antena' => 'Tamaño de Antena Radio 1',
            'port_radio' => 'Puerto Radio 1',
            'servicio' => 'Servicio',
            'orden' => 'Nro Orden',
            'client' => 'Cliente',
            'address' => 'Dirección',
            'modelo2' => 'Modelo de Radio 2',
            'radio_acro' => 'Acronimo Radio 2',
            'ne_id_radio' => 'NE-ID Radio 2',
            'loopback_ip' => 'IP LoopBack Radio 2',
            'id_frecuencia' => 'Frecuencia (ODU) Radio 2',
            'id_antena' => 'Tamaño de Antena Radio 2',
            'new_port' => 'Puerto Radio 2',
            'port_radio_if' => 'Puerto IF Radio 1',
            'port_radio2_if' => 'Puerto IF Radio 2',
        ];
    }
}
