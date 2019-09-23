@if($prefatture_da_associare->count())
<div class="m-invoice__body">
<div class="m-form__group form-group">
	<label>Prefatture da associare</label>
  <div class="m-checkbox-list">
  @foreach ($prefatture_da_associare as $p)
    <label class="m-checkbox m-checkbox--square">
      <input type="checkbox" name="prefatture[]" class="fatture_prefatture" @if(in_array($p->id, $prefatture_associate)) checked="checked"@endif value="{{$p->id}}"> {{$p->getPrefatturaDaAssociare()}}
      <span></span>
    </label>
  @endforeach
  </div>
</div>
</div>
@endif