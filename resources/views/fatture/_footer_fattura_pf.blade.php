<div class="m-invoice__footer">
    <div class="m-invoice__table  m-invoice__table--centered">
        <form class="" action="{{ route('fatture.add-note') }}" method="POST" accept-charset="utf-8">
        <div class="row">        
                @csrf
                <input type="hidden" name="fattura_id" value="{{$fattura->id}}">
                <label class="col-lg-1 col-form-label text-right" for="note">Note:</label>
                <div class="col-lg-5">
                    <textarea name="note" class="form-control m-input m-input--air m-input--pill" id="note" rows="4">{{ old('note') != '' ?  old('note') : optional($fattura)->note}}</textarea>
                </div>
                <div class="col-lg-2" style="align-self: flex-end; margin-bottom: 12px;">
                    <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide">
                        <span><i class="fa flaticon-chat-1"></i><span>Aggiungi</span></span>
                    </button>
                </div>
                <div class="col-lg-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>TOTALE FATTURA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="m--font-danger">{{App\Utility::formatta_cifra($fattura->getTotale($save=true), '€')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
        </form>
    </div>
</div>