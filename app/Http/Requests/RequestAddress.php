<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAddress extends FormRequest
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
            'pais'=>'required|regex:/[0-9]/',
            'provin'=>'required|regex:/[0-9]/',
            'local'=>'required|regex:/[A-Z-0-9 _]/|max:50|min:4',
            'calle'=>'required|regex:/[A-Z-0-9 _]/|max:200',
            'altura'=>'required|max:6|regex:/[0-9]/',
            'piso'=>'max:11',
            'apartamento'=>'max:50',
            'postal'=>'max:8',
        ];
    }

    public function attributes()
    {
        return [
            'pais' => 'Pais',
            'provin'=> 'Provincia',
            'local'=> 'Localidad',
            'calle' => 'Calle',
            'altura'=> 'Altura',
            'piso'=> 'Piso',
            'apartamento'=> 'Apartamento',
            'postal'=> 'Codigo Postal',
        ];
    }
}
