<?php

namespace App\Http\Controllers;

use App\User;
use App\Conteggio;
use App\RigaConteggio;
use Illuminate\Http\Request;
use App\Mail\AperturaConteggio;
use App\Mail\ChiusuraConteggio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;

class ConteggiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($commerciale_id = null)
    {
    if (is_null($commerciale_id)) 
      {
      $conteggi = Auth::user()->conteggi_terminati()->orderBy('id', 'desc')->paginate(50);
      } 
    else 
      {
      $commerciale = User::findOrFail($commerciale_id);
      $conteggi = $commerciale->conteggi()->orderBy('id', 'desc')->paginate(50);
      }

    return view('conteggi.index', compact('conteggi'));
    }


    public function indexCommerciali()
      {
      $commerciali = User::commerciale()->has('conteggi')->withCount('conteggi')->get();

      return view('conteggi.index_commerciali', compact('commerciali'));

      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Conteggio::create($request->get('titolo'));

        return redirect('conteggi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
    }



    public function termina(Request $request, $id)
      {
      $conteggio = Conteggio::with('commerciale')->find($id);

      $conteggio->terminato = 1;
      
      $conteggio->save();

      Mail::to(env('CONTEGGIO_MAIL_TO'))->send(new ChiusuraConteggio($conteggio));

      return redirect()->route('conteggi.edit', ['id' => $id])->with('status', 'Il conteggio è stato chiuso e una notifica via mail è stata inviata allo staff');

      }

      public function apri(Request $request, $id)
        {
        $conteggio = Conteggio::with('commerciale')->find($id);

        $conteggio->terminato = 0;
        
        $conteggio->save();

        Mail::to($conteggio->commerciale->email)->send(new AperturaConteggio($conteggio));

        return redirect()->route('conteggi.index', $conteggio->commerciale->id)->with('status', 'Il conteggio è stato riaperto e una notifica via mail è stata inviata al commerciale');

        }

      
      public function approva(Request $request, $id)
        {
        $conteggio = Conteggio::with('commerciale')->find($id);

        $conteggio->approvato = 0;
        
        $conteggio->save();

        Mail::to($conteggio->commerciale->email)->send(new AperturaConteggio($conteggio));

        return redirect()->route('conteggi.index', $conteggio->commerciale->id)->with('status', 'Il conteggio è stato approvato e una notifica via mail è stata inviata al commerciale');

        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $conteggio = Conteggio::with('righe.cliente')->find($id);
        
        $orderby = $request->get('orderby','id');
        $order = $request->get('order','desc');

				$righe = $conteggio->righe();

        if ($orderby == 'id_info' || $orderby == 'nome') 
          {
					$righe= $righe
										->select(DB::raw('tblRigheConteggi.*, tblClienti.id_info'))
										->join('tblClienti', 'tblClienti.id', '=', 'tblRigheConteggi.cliente_id')
										->with([
												'cliente',
												'modalita',
												'servizi.prodotto'
												])
										->orderBy($orderby,$order);
					}
				elseif($orderby == 'nome_servizio')
					{
						$righe= $righe
						->select(DB::raw('tblRigheConteggi.*, tblProdotti.nome'))
						->join('tblRigaConteggioServizio', 'tblRigaConteggioServizio.riga_conteggio_id', '=', 'tblRigheConteggi.id')
						->join('tblServizi', 'tblServizi.id', '=', 'tblRigaConteggioServizio.servizio_id')
						->join('tblProdotti', 'tblProdotti.id', '=', 'tblServizi.prodotto_id')
						->with([
								'cliente',
								'modalita',
								'servizi.prodotto'
								])
						->orderBy('nome',$order);
					}
				elseif($orderby == 'nome_modalita')
					{
						$righe= $righe
						->select(DB::raw('tblRigheConteggi.*, tblModalitaVendita.nome'))
						->join('tblModalitaVendita', 'tblModalitaVendita.id', '=', 'tblRigheConteggi.modalita_id')
						->with([
								'cliente',
								'modalita',
								'servizi.prodotto'
								])
						->orderBy('nome',$order);
					}
				else
					{
						$righe= $righe
						->with([
								'cliente',
								'modalita',
								'servizi.prodotto'
								])
						->orderBy($orderby,$order);
					}

				//dd($righe->get()->take(5));
				$to_append = ['order' => $order, 'orderby' => $orderby];
				

				$righe = $righe->paginate(50)->setpath('')->appends($to_append);


        return view('conteggi.index_righe', compact('conteggio','righe'));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
			$conteggio = Conteggio::with('righe.cliente')->find($id);
      dd($conteggio);
		}
		

		public function destroyRiga($riga_conteggio_id)
    {
			$riga_conteggio = RigaConteggio::find($riga_conteggio_id);

			$conteggio_id = $riga_conteggio->conteggio_id;
			
			$riga_conteggio->destroyMe();
			
			return redirect()->route('conteggi.edit',$conteggio_id)->with('status', 'Riga conteggio elimnata correttamente!');
		}

		
}
