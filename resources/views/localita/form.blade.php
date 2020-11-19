@extends('layouts.coreui.crm_lara6')



@section('content')
<div class="row">
  <div class="col">
    
    <form action="{{route('localita.store')}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group row">
        <label class="col-md-2 text-change" for="nome">Località:</label>
        <div class="col-md-6">
          <input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') : ''}}"  class="form-control" placeholder="Nome località">
        </div>
      </div>


      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Comune:</label>
        <div class="col-md-6">
            <select class="form-control" id="comune" name="comune">
              @foreach ($comuni_arr as $id => $comune)
                <option id="{{$id}}" @if (old('comune') == $id ) selected="selected" @endif>{{$comune}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">Carica</button>
        
      
    </form>
    
  </div>
</div>
@endsection