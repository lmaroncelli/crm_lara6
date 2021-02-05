<?php

namespace App\Http\Requests;

use App\Utility;
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
            $rules['n_camere'] = 'required|gt:0';
            $rules['n_letti'] = 'required|gt:0';
            $rules['n_app'] = 'required|gte:0';
            $rules['n_suite'] = 'required|gte:0';            
        }

        $rules['checkin'] = 'required';
        $rules['checkout'] = 'required';
        $rules['caparra'] = "not_in:seleziona";

        // trattamenti almeno 1 voce
        // se non  sono selezionate c'è hidden = 0
        if ( !$this->request->get('ai') &&
            !$this->request->get('pc') &&
            !$this->request->get('mp') &&
            !$this->request->get('mp_spiaggia') &&
            !$this->request->get('bb') &&
            !$this->request->get('bb_spiaggia') &&
            !$this->request->get('sd') &&
            !$this->request->get('sd_spiaggia') ) {

                $rules['ai'] = 'not_in:0';
               
            }

        // se selziono un trattamento devo specificare le note relative
        foreach (Utility::getFsTrattamentiENote() as $key => $val) {
            if(strpos($key, 'note_') === false && $this->request->get($key) && $this->request->get('note_'.$key) == '') {
                $rules['note_'. $key] = 'required';
            }
        }

        // pagamenti almeno 1 voce
        // se non  sono selezionate c'è hidden = 0
        if (
            !$this->request->get('contanti') &&
            !$this->request->get('assegno') &&
            !$this->request->get('carta_credito') &&
            !$this->request->get('bonifico') &&
            !$this->request->get('paypal') &&
            !$this->request->get('bancomat')
        ) {

            $rules['contanti'] = 'not_in:0';
        }


        // lingue almeno 1 voce
        // se non  sono selezionate c'è hidden = 0
        if (
            !$this->request->get('inglese') &&
            !$this->request->get('francese') &&
            !$this->request->get('tedesco') &&
            !$this->request->get('spagnolo') &&
            !$this->request->get('russo')
        ) {

            $rules['inglese'] = 'not_in:0';
        }


        // PISCINA

        if ($this->request->get('piscina')) {
            $rules['sup'] = 'required|gt:0';

            if(
                ($this->request->get('h') == '' || $this->request->get('h') == 0) &&
                ($this->request->get('h_min') == '' || $this->request->get('h_min') == 0) && 
                ($this->request->get('h_max') == '' || $this->request->get('h_max') == 0)
              ) {

                    $rules['h'] = 'required|gte:0';
                    $rules['h_min'] = 'required|gte:0';
                    $rules['h_max'] = 'required|gte:0';

            }
            

            if ($this->request->get('aperto_dal') == $this->request->get('aperto_al')) {
                $rules['aperto_annuale'] = 'required';
                
            }

            $rules['posizione'] = 'required';

            $rules['lettini_dispo'] = 'required|gte:0';

            $rules['espo_sole'] = 'required|gte:0';
            $rules['vasca_bimbi_sup'] = 'required|gte:0';
            $rules['vasca_bimbi_h'] = 'required|gte:0';
            $rules['vasca_idro_n_dispo'] = 'required|gte:0';
            $rules['vasca_idro_posti_dispo'] = 'required|gte:0';

        }

        //dd($rules);

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
            'ai.not_in' => 'Selezionare almeno un trattamento',
            'contanti.not_in' => 'Selezionare almeno un pagamento',
            'inglese.not_in' => 'Selezionare almeno una lingua parlata',
            'sup.gt' => 'Specificare una superficie della piscina maggiore di 0',
            'posizione.required' => 'Specificare la posizione della piscina',
            'aperto_annuale.required' => 'I mesi di apertura e chiusura della piscina coincidono. Specificare annuale',


            'lettini_dispop.gte' => 'Specificare un numero di lettini maggiore di 0',
            'espo_sole.gte' => 'Specificare un numero di ore di esposizione al sole maggiore di 0',
            'vasca_bimbi_sup.gte' => 'Specificare una superficie della vasca bimbi maggiore di 0',
            'vasca_bimbi_h.gte' => 'Specificare una altezza della vasca bimbi maggiore di 0',
            'vasca_idro_n_dispo.gte' => 'Specificare le vasche disponibili',
            'vasca_idro_posti_dispo.gte' => 'Specificare i posti disponibili delle vasche',

        ];

        foreach (Utility::getFsTrattamentiENote() as $key => $val) {
            if (strpos($key, 'note_') === false && $this->request->get($key) && $this->request->get('note_' . $key) == '') {
                $messages['note_' . $key. '.required'] = 'Inserire le note per ogni trattamento selezionato';
            }
        }

        //dd($messages);

        return $messages;
    }
}
