<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Fattura;
use App\Memorex;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  Memorex scaduti
        $memorex_count = Memorex::notHM()
            ->scadute()
            ->count();

        
        $clienti_attivi_count = Cliente::attivo()->count();
        $clienti_attivi_ia_count = Cliente::attivoIA()->count();


        //  fatture ultimi 10 gg
        $last_days = 10;
        $date_ago = Carbon::now()->subDays($last_days)->toDateString();

        $fatture_count = Fattura::withoutGlobalScope('data')->where('tipo_id', 'F')->where('created_at', '>', $date_ago)->count();
        $prefatture_count = Fattura::withoutGlobalScope('data')->where('tipo_id','PF')->where('created_at','>',$date_ago)->count();

        //dd(Str::replaceArray('?', $fatture_count->getBindings(), $fatture_count->toSql()));

        return view('home', compact('memorex_count', 'clienti_attivi_count', 'clienti_attivi_ia_count', 'fatture_count', 'prefatture_count', 'last_days'));
    }


    public function prova() 
    {
        $clienti = [];
        $commerciale_id = 5;

        $clienti_associati = User::with(
                [
                'clienti_associati.servizi_attivi.righeConteggi',
                'clienti_associati.localita'
                ])
                ->find($commerciale_id)
                ->clienti_associati;

        //dd($clienti_associati->first());
        
        $clienti_filtered = $clienti_associati->reject(function ($cliente, $key) {

            $all_servizi = $cliente->servizi_attivi;
          
            $trovato = false;
            foreach ($all_servizi as $servizio) {
                if( $servizio->righeConteggi->count() == 0) {
                // CE NE E' ALMENO 1 CHE NON E' IN NESSUN CONTEGGIO 
                $trovato = true;
                //echo 'servizio id '.$servizio->id;
                break;
                }
            }
        
            // il cliente lo prendo (NON LO RIGETTO)
            return !$trovato;
            
        });
        
        //$clienti_filtered = $clienti_associati;
        
        foreach ($clienti_filtered as $cliente) {
            $c['id'] = $cliente->id;
            $c['nome'] = $cliente->nome . ' (' . $cliente->id_info . ') - '. $cliente->localita->nome;
            $clienti[] = $c;
        }      

        return view('home');	
    }
}
