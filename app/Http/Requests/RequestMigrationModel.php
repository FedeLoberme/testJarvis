<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestMigrationModel extends FormRequest
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
            'id' => 'required',
            //'port_new' => 'required',
            //'id_port' => 'required',
            'equi_alta' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Equipo',
            //'port_new' => 'Puertos nuevos',
            //'id_port' => 'Puertos Viejos',
            'equi_alta' => 'Modelo',
        ];
    }
}
