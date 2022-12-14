<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEquipment_Model extends FormRequest
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
        switch ($this->equipo) {
            case '1':
                return [
                    'equipo' => 'required',
                    'marca' => 'required',
                    'modelo' => 'required',
                    'sap' => 'required',
                    'status' => 'required',
                    'descri' => 'required',
                    'max' => 'required',
                    'alimenta' => 'required',
                    'modulo' => 'required',
                    'licen' => 'required',
                    'encrip' => 'required',
                    'full' => 'required',
                    'multi' => 'required',
                    'dual' => 'required',
                    // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
            break;
            case '2':
                return [
                    'equipo' => 'required',
                    'marca' => 'required',
                    'modelo' => 'required',
                    'sap' => 'required',
                    'status' => 'required',
                    'descri' => 'required',
                    'max' => 'required',
                    'alimenta' => 'required',
                    'modulo' => 'required',
                    'licen' => 'required',
                    'radio' => 'required',
                    'banda' => 'required',
                    // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
            break;
            case '3':
                return [
                    'equipo' => 'required',
                    'marca' => 'required',
                    'modelo' => 'required',
                    'sap' => 'required',
                    'status' => 'required',
                    'descri' => 'required',
                    'max' => 'required',
                    'alimenta' => 'required',
                    'modulo' => 'required',
                    // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
            break;
            default:
                return [
                    'equipo' => 'required',
                    'marca' => 'required',
                    'modelo' => 'required',
                    'sap' => 'required',
                    'status' => 'required',
                    'descri' => 'required',
                    'max' => 'required',
                    'alimenta' => 'required',
                    'modulo' => 'required',
                    // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
            break;
        }
    }
    public function attributes()
    {
        return [
            'equipo' => 'Tipo de equipo',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'sap' => 'C??digo sap',
            'status' => 'Estado',
            'descri' => 'Descripci??n',
            'max' => 'Bandwitdh max',
            'alimenta' => 'Alimentaci??n',
            'modulo' => 'M??dulos / slots (Cant.)',
            'licen' => 'Bandwitdh b??sico lincenciado',
            'encrip' => 'Bandwitdh c/encripci??n',
            'full' => 'Full table',
            'multi' => 'Multivrf',
            'dual' => 'Dual stack',
            'radio' => 'Tipo radio',
            'banda' => 'Banda',
            'image' => 'Imagen',
        ];
    }

    
}
