<div class="spinner_lu prefatture" style="display:none;"></div>
<div class="form-group mb-5">
	<label>Prefatture da associare (in <span style="color:red;">rosso</span> quelle già pagate)</label>
  @foreach ($prefatture_da_associare as $p)
    <div class="m-checkbox-list">
    @if (!$p->scadenze_da_pagare())
      <input type="checkbox" disabled name="prefatture[]" class="fatture_prefatture" @if(in_array($p->id, $prefatture_associate)) checked="checked"@endif value="{{$p->id}}">
      <span style="color:red;">{{$p->getPrefatturaDaAssociare()}}</span>
    @else
      <input type="checkbox" name="prefatture[]" class="fatture_prefatture" @if(in_array($p->id, $prefatture_associate)) checked="checked"@endif value="{{$p->id}}"> 
      {{$p->getPrefatturaDaAssociare()}}
    @endif
    </div>
  @endforeach
</div>