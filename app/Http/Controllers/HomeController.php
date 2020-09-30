<?php

namespace App\Http\Controllers;

use App\User;
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
        return view('home');
    }


    public function prova() 
    {
        $clienti = [];
        $commerciale_id = 5;

        $clienti_associati = User::with([
                        'clienti_associati.servizi_attivi.righeConteggi',
                        'clienti_associati.localita'])
                                    ->find($commerciale_id)
                                    ->clienti_associati;
        
        // $clienti_filtered = [];

        // foreach ($clienti_associati as $cliente) 
        // {
        //         $all_servizi = $cliente->servizi_attivi;
        //         $all_servizi->loadCount('righeConteggi');
                
        //         foreach ($all_servizi as $servizio) 
        //             {
        //             if( $servizio->righeConteggi_count == 0) 
        //                 {
        //                 // c'è almento un servizio da conteggiare
        //                 $clienti_filtered[] = $cliente;
        //                 break;
        //                 }
        //             }
        //     }

        // voglio prendere solo i clienti che hanno dei servizi da conteggiare
        $clienti_filtered = $clienti_associati->reject(function ($cliente, $key) {
           $all_servizi = $cliente->servizi_attivi;
           $all_servizi->loadCount('righeConteggi');
           $trovato = false;
           foreach ($all_servizi as $servizio) {
             if( $servizio->righeConteggi_count == 0) {
              // c'è almento un servizio da conteggiare
              $trovato = true;
              break;
             }
           }
           // il cliente lo prendo (NON LO RIGETTO)
           return !$trovato;
        });

        foreach ($clienti_filtered as $cliente) {
        $clienti[$cliente->id] = $cliente->nome . ' (' . $cliente->id_info . ') - '. $cliente->localita->nome;
        }

        return view('home');	
    }
}
