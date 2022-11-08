<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEdictRadioNode extends FormRequest
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
            'mark' => 'required|max:10',
            'id' => 'required|max:10',
            'node' => 'required|max:10',
            'acro_radio' => 'required|max:30',
            'model' => 'required|max:10',
            'gestion' => 'required|max:10',
            'ne_id' => 'required_if:mark,2|max:30',
            'loopback' => 'required_if:mark,3|max:10',
            'commen' => 'max:100',
        ];
    }
}
