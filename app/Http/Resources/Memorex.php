<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Memorex extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         *
         * array:16 [▼
          "id" => 3474
          "user_id" => 7
          "categoria" => "Info Alberghi"
          "titolo" => "Hotel Sedonia (id 1847 - Cervia)"
          "descrizione" => "scadenza inserimento"
          "giorno" => "15"
          "mese" => "06"
          "anno" => "2021"
          "minuti" => "00"
          "ore" => "07"
          "data" => "2021-06-15"
          "priorita" => "Normale"
          "completato" => 0
          "data_disattivazione" => null
          "created_at" => null
          "updated_at" => null
         *
         * 
         */


        
        $fields = parent::toArray($request);

      
        try {
          $fields['data'] = Carbon::createFromFormat('Y-m-d', $fields['data'])->format('d/m/Y');
        } catch (\Exception $e) {
          // do nothing
        }

        $fields['riferimento'] = optional($this->commerciale)->name;
        
        return $fields;
    }
}
