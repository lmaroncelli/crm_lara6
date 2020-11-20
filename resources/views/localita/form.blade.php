@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="row">
  <div class="col">
    

    @if (!$localita->exists)
      <form action="{{route('localita.store')}}" method="post" enctype="multipart/form-data">
    @else
      <form action="{{route('localita.update',[$localita->id])}}" method="post" enctype="multipart/form-data">
        @method('PUT')
    @endif
      @csrf

      <div class="form-group row">
        <label class="col-md-2 text-change" for="nome">Località:</label>
        <div class="col-md-6">
          <input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') :  $localita->exists ? $localita->nome : ''}}"  class="form-control" placeholder="Nome località">
        </div>
      </div>


      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Comune:</label>
        <div class="col-md-6">
            <select class="form-control" id="comune_id" name="comune_id">
              @foreach ($comuni_arr as $id => $comune)
                <option value="{{$id}}" @if (old('comune_id') == $id ) selected="selected" @elseif($localita->exists && $localita->comune_id == $id) selected="selected" @endif>{{$comune}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">
      @if (!$localita->exists) Salva @else Modifica @endif
      </button>
      <a href="{{ route('localita.index') }}  " class="btn btn-success offset-md-2 mt-3 mb-4">Annulla</a>
        
      
    </form>
    
  </div>
</div>
@endsection