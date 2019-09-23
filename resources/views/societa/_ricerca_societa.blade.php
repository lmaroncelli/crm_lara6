<form action="{{ url('societa') }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    <div class="row">
        

        <div class="col-lg-5" style="padding-left: 40px; padding-right: 40px; padding-top: 20px">
            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca nel campo">
                <span class="m-input-icon__icon m-input-icon__icon--left">
                    <span>
                        <i class="la la-tags"></i>
                    </span>
                </span>
                <span class="m-input-icon__icon m-input-icon__icon--right">
                    <span>
                        <i class="la la-search"></i>
                    </span>
                </span>
            </div>
        </div>
        <div class="col-lg-3" style="padding-top: 20px;">
            <select class="form-control m-input" id="field" name="field">
                @foreach ($campi_societa_search as $key => $value)
                    <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>

    </div>
</form>