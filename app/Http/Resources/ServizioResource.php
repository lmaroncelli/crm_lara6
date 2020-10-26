<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ServizioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $fields = parent::toArray($request);


        try {
            $fields['data_inizio_forjs'] = Carbon::createFromFormat('Y-m-d', $fields['data_inizio'])->format('m/d/Y');
        } catch (Exception $e) {
            // do nothing
        }

        try {
            $fields['data_fine_forjs'] = Carbon::createFromFormat('Y-m-d', $fields['data_fine'])->format('m/d/Y');
        } catch (Exception $e) {
            // do nothing
        }


    


        return $fields;
    }
}
