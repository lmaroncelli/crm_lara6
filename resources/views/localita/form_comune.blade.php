@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="row">
  <div class="col">
    

    @if (!$comune->exists)
      <form action="{{route('comune.store')}}" method="post" enctype="multipart/form-data">
    @else
      <form action="{{route('comune.update',[$comune->id])}}" method="post" enctype="multipart/form-data">
    @endif
      @csrf

      <div class="form-group row">
        <label class="col-md-2 text-change" for="nome">Comune:</label>
        <div class="col-md-6">
          <input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') :  $comune->exists ? $comune->nome : ''}}"  class="form-control" placeholder="Nome comune">
        </div>
      </div>


      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Provincia:</label>
        <div class="col-md-6">
            <select class="form-control" id="provincia_id" name="provincia_id">
              @foreach ($province_arr as $id => $provincia)
                <option value="{{$id}}" @if (old('provincia_id') == $id ) selected="selected" @elseif($comune->exists && $comune->provincia_id == $id) selected="selected" @endif>{{$provincia}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">
      @if (!$comune->exists) Salva @else Modifica @endif
      </button>
      <a href="{{ route('localita.index') }}  " class="btn btn-success offset-md-2 mt-3 mb-4">Annulla</a>
        
      
    </form>
    
  </div>
</div>
@endsection