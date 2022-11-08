<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestClient extends FormRequest
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
            'name'=>'required|max:80',
            'acronimo'=>'max:4|regex:/[A-Za-z]{4,4}/',
            'cuit'=>'regex:/[0-9]{11,11}/|max:11||min:11',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Razón social',
            'acronimo'=> 'Acronimo',
            'cuit'=> 'Cuit',
        ];
    }
}
