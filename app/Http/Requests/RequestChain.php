<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestChain extends FormRequest
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
            'name' => 'required|max:50',
            'extrem_1' => 'required|max:100',
            'extrem_2' => 'max:100',
            'BW' => 'required|max:10',
            'max' => 'required|max:20',
            'commentary' => 'max:100',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'extrem_1'=> 'Extremo 1',
            'extrem_2'=> 'Extremo 2',
            'BW' => 'Ancho de Banda',
            'max'=> 'Ancho de Banda',
            'commentary'=> 'Comentario',
        ];
    }
}
