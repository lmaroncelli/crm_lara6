<?php

namespace App\Http\Controllers;

use App\Vetrina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VetrineController extends Controller
{

		var $num_items;


		public function __construct()
		{
			$this->num_items = 20;
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
                    'nome' => 'required|unique:tblVetrine,id,'.$id.'|max:255'
                ];
            }
        

        $custom_messages['nome.required'] = 'Inserire la vetrina';
        $custom_messages['nome.unique'] = 'La vetrina inserita esiste già';
        

        return  Validator::make( $data ,$validation_rules,$custom_messages );
        } 
            

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			$vetrine = Vetrina::withCount('slots')->orderBy('nome','asc')->paginate($this->num_items);
			return view('vetrine.index', compact('vetrine'));

		}
		
		public function slot_index($vetrina_id = 0)
    {
			$vetrina = Vetrina::find($vetrina_id);
			$slots = $vetrina->slots()->paginate($this->num_items);

			return view('vetrine.slots_index', compact('slots','vetrina'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vetrina = new Vetrina;

        return view('vetrine.form', compact('vetrina'));

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
				
        Vetrina::create($request->all());

        return redirect()->route('vetrine.index')->with('status', 'Vetrina inserita correttamente!');
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
        //
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
        //
    }
}
