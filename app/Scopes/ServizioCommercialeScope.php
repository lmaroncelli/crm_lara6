<?php

namespace App\Scopes;

use App\User;
use App\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class ServizioCommercialeScope implements Scope
{
  /**
   * Apply the scope to a given Eloquent query builder.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $builder
   * @param  \Illuminate\Database\Eloquent\Model  $model
   * @return void
   */
  public function apply(Builder $builder, Model $model)
  {
    //? ========================================================================== //
    //? ATTENZIONE NON POSSO USARE LA RELAZIONE clienti_visibili xché CREA UN LOOP //
    //? ========================================================================== //

    if (Auth::check()) {
      if (Auth::user()->hasType('C')) {

        $clienti_commerciale_ids_arr = Utility::getClientiIdsCommerciale();

        
        $builder->whereIn('cliente_id', $clienti_commerciale_ids_arr);
        
      }
    }
  }
}
