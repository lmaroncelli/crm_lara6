<?php

namespace App\Http\Controllers;

use App\Conteggio;
use App\RigaConteggio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ConteggiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $conteggi = Auth::user()->conteggi()->orderBy('id', 'desc')->paginate(50);

    return view('conteggi.index', compact('conteggi'));
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
