@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="row">
  <div class="col">
    

    @if (!$vetrina->exists)
      <form action="{{route('vetrine.store')}}" method="post" enctype="multipart/form-data">
    @else
      <form action="{{route('vetrine.update',[$vetrina->id])}}" method="post" enctype="multipart/form-data">
        @method('PUT')
    @endif
      @csrf

      <div class="form-group row">
        <label class="col-md-2 text-change" for="nome">Nome:</label>
        <div class="col-md-6">
          <input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') :  $vetrina->exists ? $vetrina->nome : ''}}"  class="form-control" placeholder="nome vetrina">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="descrizione">descrizione:</label>
        <div class="col-md-6">
            <textarea name="descrizione" class="form-control" id="descrizione" placeholder="descrizione vetrina" rows="4">{{ old('descrizione') != '' ?  old('descrizione') : $vetrina->descrizione}}</textarea>
        </div>
      </div>


      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Tipo:</label>
        <div class="col-md-6">
            <select class="form-control" id="tipo" name="tipo">
              @foreach (['Principale','Limitrofa'] as $tipo)
                <option value="{{$tipo}}" @if (old('tipo') == $tipo ) selected="selected" @elseif($vetrina->exists && $vetrina->tipo == $tipo) selected="selected" @endif>{{$tipo}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">
      @if (!$vetrina->exists) Salva @else Modifica @endif
      </button>
      <a href="{{ route('vetrine.index') }}  " class="btn btn-success offset-md-2 mt-3 mb-4">Annulla</a>
        
      
    </form>
    
  </div>
</div>
@endsection