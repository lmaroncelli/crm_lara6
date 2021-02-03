<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoglioServiziRequest extends FormRequest
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
        
        $rules = [
            'nome_hotel' => 'required|max:255',
            'sms' => 'required|digits_between:1,99999999999',
            'localita' => 'required|max:255',
            'whatsapp' => 'required|digits_between:1,99999999999',
            'stagione' => 'required|max:255',
        ];

        if ($this->request->has('prezzo_min') && $this->request->get('prezzo_min') != '')  {
            $rules['prezzo_min'] = 'regex:/^[\-+]?[0-9]+\,[0-9]+$/';
        }

        if ($this->request->has('prezzo_max') && $this->request->get('prezzo_max') != '') {
            $rules['prezzo_max'] = 'regex:/^[\-+]?[0-9]+\,[0-9]+$/';
        }

        if (!$this->request->has('pti_anno_prec')) {
            for ($i = 1; $i < 10; $i++) {
                $col = 'pf_' . $i;
                $rules[$col] = 'required|max:255';
            }
        }

        $rules['tipo'] = 'not_in:0';
        $rules['categoria'] = 'not_in:0';
        $rules['tipo_apertura'] = 'not_in:0';


        if ($this->request->has('tipo_apertura') && $this->request->get('tipo_apertura') == 's') {
            $rules['dal'] = 'required|date_format:d/m/Y';
            $rules['al'] = 'required|date_format:d/m/Y';
        }

        if ($this->request->has('numeri_anno_prec') && $this->request->get('numeri_anno_prec') == '0') {
            $rules['n_camere'] = 'required|regex:/^[1-9]*$/';
            $rules['n_letti'] = 'required|regex:/^[1-9]*$/';
            $rules['n_app'] = 'required|regex:/^[0-9]*$/';
            $rules['n_suite'] = 'required|regex:/^[0-9]*$/';

            
        }


        $rules['checkin'] = 'required';
        $rules['checkout'] = 'required';

        $rules['caparra'] = "not_in:seleziona";

        

        
    

        return $rules;
    }


    public function messages() {
        $messages = [
            'sms.digits_between' => 'Il campo sms deve contenere solo numeri',
            'whatsapp.digits_between' => 'Il campo whatsapp deve contenere solo numeri',
            'tipo.not_in' => 'Specificare la tipologia di struttura',
            'categoria.not_in' => 'Specificare la categoria della struttura',
            'tipo_apertura.not_in' => 'Specificare il tipo di apertura della struttura',
            'dal.required' => 'Specificare la data di apertura della struttura',
            'al.required' => 'Specificare la data di chiusura della struttura',
            'dal.date_format' => 'La data di apertura della struttura non ha un formato valido (d/m/Y)',
            'al.date_format' => 'La data di chiusura della struttura non ha un formato valido (d/m/Y)',
            'n_camere.regex' => 'Specificare un numero di camere maggiore di 0',
            'n_letti.regex' => 'Specificare un numero di letti maggiore di 0',
            'n_app.regex' => 'Specificare un numero di appartamenti (nel caso 0)',
            'n_suite.regex' => 'Specificare un numero di suite (nel caso 0)',
        ];

        return $messages;
    }
}
