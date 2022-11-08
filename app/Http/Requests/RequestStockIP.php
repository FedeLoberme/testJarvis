<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStockIP extends FormRequest
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
            'id'=>'required|regex:/[0-9]/|',
            'status'=>'required|max:10',
            'ip'=>'required|regex:/[0-9\.]{6,15}/|max:15',
            'use'=>'max:50',
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Identificador',
            'status'=> 'Estado',
            'ip'=> 'IP',
            'use'=> 'Uso',
        ];
    }
}
