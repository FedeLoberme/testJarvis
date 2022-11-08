<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestReserve extends FormRequest
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
            'number_reserve' => 'max:50',
            'id_link' => 'required|max:100',
            'id_cliente' => 'required|max:100',
            'bw_reserve' => 'required|numeric|min:0|not_in:0',
            'status' => '',
            'id_user' => 'max:10',
            'quantity_dates' => '',
            'oportunity' => 'required',
            'id_service_type' => 'required|max:10',
            'commentary' => 'max:100',
            'cell_status' => 'required',
            'cell_bw_link' => 'required',
            'cell_bw_usado' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'number_reserve' => 'Numero de reserva',
            'id_link' => 'Link',
            'id_cliente' => 'Cliente',
            'bw_reserve' => 'Bandwidth reservado',
            'status' => 'Estado',
            'id_user' => 'Usuario',
            'quantity_dates' => 'Cantidad de dias',
            'oportunity' => 'Oportunidad',
            'id_service_type' => 'Tipo de servicio',
            'commentary' => 'Comentario',
            'cell_status' => 'Informacion de celda',
            'cell_bw_link' => 'Bandwidth de link de celda',
            'cell_bw_usado' => 'Bandwidth usado de celda',
        ];
    }
}