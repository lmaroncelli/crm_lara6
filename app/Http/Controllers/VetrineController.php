<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\SlotVetrina;
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
				
				protected function validatorSlot(array $data, $slot_id = null)
				{
					$validation_rules = [
						'data_disattivazione' => 'required|date_format:"d/m/Y"',
					];

					if (is_null($slot_id)) 
						{
							$validation_rules['cliente_id'] = 'required|unique:tblSlotVetrine,cliente_id,'.$data['cliente_id'];
						} 
					else 
						{
						$validation_rules['cliente_id'] = 'required';
						}
					
					
	
					$custom_messages['data_disattivazione.required'] = 'Inserire la data di disattivazione';
					$custom_messages['data_disattivazione.date_format'] = 'La data di disattivazione non è nel formato corretto';
					$custom_messages['cliente_id.unique'] = 'Il cliente ha già una vetrina';
					
	
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
			$vetrina = Vetrina::with(['slots.cliente'])->find($vetrina_id);
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
		

		public function slot_create($vetrina_id = 0)
			{
			$slot = new SlotVetrina;
			$vetrina = Vetrina::find($vetrina_id);
			$clienti = Cliente::attivo()->attivoIA()->orderBy('id_info')->get();

			$clienti_select = [];
			foreach ($clienti as $cliente) 
				{
					$clienti_select[$cliente->id] = $cliente->id_info . ' - ' . $cliente->nome;
				}

			return view('vetrine.slot_form', compact('slot','vetrina','clienti_select'));

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
		
		public function slot_store(Request $request, $vetrina_id)
			{
				$this->validatorSlot($request->all())->validate();

				$slot = new SlotVetrina(
						[
						'cliente_id' => $request->get('cliente_id'), 
						'data_disattivazione' => $request->get('data_disattivazione')
						]);

				$vetrina = Vetrina::find($vetrina_id);

				$vetrina->slots()->save($slot);

        return redirect()->route('slot.index',$vetrina_id)->with('status', 'Slot inserito correttamente!');

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
			$vetrina = Vetrina::find($id);

      return view('vetrine.form', compact('vetrina'));

			}
		
		public function slot_edit($slot_id = 0)
			{
			
			$slot = SlotVetrina::find($slot_id);

			$vetrina = $slot->vetrina;
			
			$clienti = Cliente::attivo()->attivoIA()->orderBy('id_info')->get();

			$clienti_select = [];
			foreach ($clienti as $cliente) 
				{
					$clienti_select[$cliente->id] = $cliente->id_info . ' - ' . $cliente->nome;
				}

			return view('vetrine.slot_form', compact('slot','vetrina','clienti_select'));

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
			
			$vetrina = Vetrina::find($id);

			$vetrina->update($request->all());

			return redirect()->route('vetrine.index')->with('status', 'Vetrina modificata correttamente!');
		}
		
		public function slot_update(Request $request, $slot_id)
			{
				$this->validatorSlot($request->all(), $slot_id)->validate();

				$slot = SlotVetrina::find($slot_id);
				$slot->cliente_id =  $request->get('cliente_id'); 
				$slot->data_disattivazione = $request->get('data_disattivazione');
				
				$slot->save();
				
        return redirect()->route('slot.index',$slot->vetrina_id)->with('status', 'Slot modificato correttamente!');

			}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
			$vetrina = Vetrina::find($id);
			$vetrina->destroyMe();

			return redirect()->route('vetrine.index')->with('status', 'Vetrina eliminata correttamente!');
		}
		
		public function slot_destroy($slot_id)
			{
			$slot = SlotVetrina::find($slot_id);
			$vetrina_id = $slot->vetrina_id;
			$slot->delete();

			return redirect()->route('slot.index',$vetrina_id)->with('status', 'Slot eliminato correttamente!');
			}
}
