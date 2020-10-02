<?php

namespace App\Http\Controllers;

use App\Conteggio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function edit($id)
    {
        $conteggio = Conteggio::with('righe.cliente')->find($id);

        $righe = $conteggio->righe()->with(['conteggio', 'cliente','modalita','servizi.prodotto'])->paginate(50);

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
        //
    }
}
