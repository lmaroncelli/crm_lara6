<div class="form-group">
  @foreach ($rag_soc as $r)
    <input type="radio" value="{{$r->id}}" name="societa" class="" id="{{$r->id}}">
    <label for="{{$r->id}}">  {{$r->nome}} ({{$r->piva}}) </label><br>
  @endforeach
</div>
