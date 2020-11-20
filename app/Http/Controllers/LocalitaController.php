<?php

namespace App\Http\Controllers;

use App\Comune;
use App\Localita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalitaController extends Controller
{

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
						'nome' => 'required|unique:tblLocalita,except,'.$id.'|max:255'
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
    public function index()
    {
    $localita = Localita::with(['comune.provincia.regione'])->orderBy('nome','asc')->paginate(50);

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
			$this->validator($request->all())->validate();
			
			$localita = Localita::find($id);



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
