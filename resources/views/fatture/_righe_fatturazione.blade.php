<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Servizio</th>
                <th>Qta</th>
                <th>Prezzo</th>
                <th>T.Netto</th>
                <th>% Sconto</th>
                <th>T.Netto scontato</th>
                <th>Al.IVA</th>
                <th>IVA</th>
                <th>Totale</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($fattura->righe as $riga)
            <tr>
                <td style="max-width: 200px!important">{{$riga->servizio}}</td>
                <td>{{$riga->qta}}</td>
                <td>{{App\Utility::formatta_cifra($riga->prezzo, '€')}}</td>
                <td>{{App\Utility::formatta_cifra($riga->totale_netto, '€')}}</td>
                <td>{{$riga->perc_sconto}}%</td>
                <td>{{App\Utility::formatta_cifra($riga->totale_netto_scontato, '€')}}</td>
                <td>{{$riga->al_iva}}</td>
                <td>{{App\Utility::formatta_cifra($riga->iva, '€')}}</td>
                <td>{{App\Utility::formatta_cifra($riga->totale, '€')}}</td>
                <td>
                    <a href="{{ route('fatture.load-riga',['rigafattura_id' => $riga->id]) }}" class="btn btn-info">
                    <i class="fa fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form action="{{ route('fatture.delete-riga') }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="rigafattura_id" value="{{ $riga->id }}" />
                        <a href="#" class="delete btn btn-danger"> 
                            <i class="fa fa-trash"></i>
                        </a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

    