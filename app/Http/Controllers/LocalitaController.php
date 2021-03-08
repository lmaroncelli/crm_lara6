<?php

namespace App\Http\Controllers;

use App\Comune;
use App\Localita;
use App\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocalitaController extends Controller
{

		public function __construct()
		{
			$this->middleware('forbiddenIfType:C');
		}

		protected function validator_comune(array $data, $id = null)
			{
				if (is_null($id)) 
				{
					$validation_rules = [
						'nome' => 'required|unique:tblComuni|max:255'
					];
				} 
			else 
				{
					$validation_rules = [
						'nome' => 'required|unique:tblComuni,id,'.$id.'|max:255'
					];
				}
			

			$custom_messages['nome.required'] = 'Inserire il comune';
			$custom_messages['nome.unique'] = 'Il comune inserito esiste già';
			

			return  Validator::make( $data ,$validation_rules,$custom_messages );
			}

    protected function validator(array $data, $id = null)
    	{
			
			if (is_null($id)) 
				{
					$validation_rules = [
						'nome' => 'required|unique:tblLocalita|max:255'
					];
				} 
			else 
				{
					$validation_rules = [
						'nome' => 'required|unique:tblLocalita,id,'.$id.'|max:255'
					];
				}
			

			$custom_messages['nome.required'] = 'Inserire la località';
			$custom_messages['nome.unique'] = 'La località inserita esiste già';
			

			return  Validator::make( $data ,$validation_rules,$custom_messages );
			} 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
		

		// campo libero
		$qf = $request->get('qf');
		$field = $request->get('field');
		
		$orderby = $request->get('orderby');
		$order = $request->get('order');

		if(is_null($order))
		{
			$order='asc';
		}

	if(is_null($orderby))
		{
			$orderby='nome';
		}


	
		$localita = Localita::with([
				'comune',
				'comune.provincia',
				'comune.provincia.regione'
				]);

		$localita = $localita
				->select(DB::raw('tblLocalita.*, tblComuni.nome as nome_comune, tblProvince.nome as nome_provincia, tblRegioni.nome as nome_regione'))
				->join('tblComuni', 'tblComuni.id', '=', 'tblLocalita.comune_id')
				->join('tblProvince', 'tblProvince.id', '=', 'tblComuni.provincia_id')
				->join('tblRegioni', 'tblRegioni.id', '=', 'tblProvince.regione_id');

		// se ho inserito un valore da cercare ed ho selzionato un campo
		if( !is_null($qf) && $field != '0' )
			{
			if($field == 'l')
      	{
				$localita = $localita->where('tblLocalita.nome','LIKE','%'.$qf.'%'); 
				}
			elseif($field == 'c')
				{
				$localita = $localita->where('nome_comune','LIKE','%'.$qf.'%');
				}
			elseif($field == 'p')
				{
				$localita = $localita->where('nome_provincia','LIKE','%'.$qf.'%');
				}
			elseif($field == 'r')
				{
				$localita = $localita->where('nome_regione','LIKE','%'.$qf.'%');
				}
			}


		$localita = $localita->orderBy($orderby,$order);


		$to_append = ['order' => $order, 'orderby' => $orderby, 'qf' => $qf, 'field' => $field];


		
		$localita = $localita->paginate(50)->setpath('')->appends($to_append);



	

    return view('localita.index', compact('localita'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $localita = new Localita;
    $comuni_arr = Comune::orderBy('nome','asc')->pluck('nome','id')->toArray();
		
    return view('localita.form', compact('localita','comuni_arr'));
		}
		
		public function comune_create()
			{
				$comune = new Comune;
				$province_arr = Provincia::orderBy('nome','asc')->pluck('nome','id')->toArray();
				
				return view('localita.form_comune', compact('comune','province_arr'));
			}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
        {
				$this->validator($request->all())->validate();
				
				Localita::create($request->all());

				return redirect()->route('localita.index')->with('status', 'Località inserita correttamente!');
    
				}
				

		public function comune_store(Request $request)
				{
					$this->validator_comune($request->all())->validate();
				
					Comune::create($request->all());
	
					return redirect()->route('localita.index')->with('status', 'Comune inserito correttamente!');
				}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$localita = Localita::find($id);
		$comuni_arr = Comune::orderBy('nome','asc')->pluck('nome','id')->toArray();
		
    return view('localita.form', compact('localita','comuni_arr'));
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
			$this->validator($request->all(), $id)->validate();
			
			$localita = Localita::find($id);

			$localita->update($request->all());

			return redirect()->route('localita.index')->with('status', 'Località modificata correttamente!');
			
			}
			
			public function comune_update(Request $request, $id)
    	{
				$this->validator($request->all(), $id)->validate();
			
				$comune = Comune::find($id);
	
				$comune->update($request->all());
	
				return redirect()->route('localita.index')->with('status', 'Comune modificato correttamente!');
			}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
			Localita::destroy($id);
			
			return redirect()->route('localita.index')->with('status', 'Località eliminata correttamente!');

    }
}
