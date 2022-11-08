<?php

namespace Jarvis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLink extends FormRequest
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
            'n_max' => 'required|regex:/[0-9]/|max:15',
            'max_link' => 'required|regex:/[0-9]/|max:15',
            'name' => 'required|max:50',
            'type' => 'required|regex:/[0-9]/|max:10',
            'commentary' => 'max:300',
            'nodo' => 'required|regex:/[0-9]/|max:10',
        ];
    }
}
