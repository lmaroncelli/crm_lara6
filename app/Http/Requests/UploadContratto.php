<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadContratto extends FormRequest
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
            'titolo' => 'required|max:255',
            'contratto' => 'required|mimes:pdf|max:2048'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'titolo.required' => 'Titolo obbligatorio',
            'titolo.max' => 'Titolo deve essere al massimo 255 caratteri',

            'contratto.required' => 'Caricare un contratto',
            'contratto.mimes' => 'Il contratto deve essere un PDF',
            'contratto.max' => 'Il contratto deve essere al massimo 2MB',
        ];
    }
}
