<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUseVlanNode extends FormRequest
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
            'id'=>'required',
            'uso'=>'required',
            'vlan'=>'required',
            'ip'=>'max:50',
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Nodo',
            'uso'=> 'Uso de vlan',
            'vlan'=> 'Vlan',
            'ip' => 'IP',
        ];
    }
}
