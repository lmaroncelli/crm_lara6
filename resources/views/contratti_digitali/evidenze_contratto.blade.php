
<h4 class="m-portlet__head-text" style="width: 100px;">
  Località
</h4>
{{--  Elenco macrolocalita  --}}
<div class="row">
<ul class="nav nav-tabs nav-griglia">
  @foreach ($macro as $id => $nome)
    <li class="nav-item">
      <a class="nav-link @if ($id == $macro_id) active @endif" href="{{ route('contratto-digitale.edit', ['contratto_id' => $contratto->id, 'macro_id' => $id]) }}">{{$nome}}</a>
    </li>
  @endforeach
  </ul>
</div> 
<hr>
@include('evidenze.griglia_evidenze_inc', ['contratto_digitale' => 1])
  
