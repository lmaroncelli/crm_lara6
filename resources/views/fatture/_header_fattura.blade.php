<div class="m-invoice__head" style="background-image: url(../../assets/app/media/img//logos/bg-6.jpg);">
    <div class="m-invoice__container m-invoice__container--centered">
        <div class="m-invoice__logo" style="display: flex;">
            <a href="#">
                <h1>{{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }}</h1>

                <h4 class="m--font-danger">{{App\Utility::getPagamentoFattura($fattura->pagamento_id)}}</h4>
            </a>
            <a href="#" style="margin-left: auto;">
                <img src="../../assets/app/media/img//logos/logo_client_color.png">
            </a>
        </div>
        <span class="m-invoice__desc">
            <span>Info Alberghi srl</span>
            <span>Via Gambalunga, 81/A - 47921 - Rimini(RN)</span>
        </span>
        <div class="m-invoice__items">
            <div class="m-invoice__item">
                <span class="m-invoice__subtitle">DATA</span>
                <span class="m-invoice__text">{{$fattura->data->format('d/m/Y')}}</span>
            </div>
            <div class="m-invoice__item">
                <span class="m-invoice__subtitle">{{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }} N°.</span>
                <span class="m-invoice__text">{{$fattura->tipo_id == 'PF' ? $fattura->numero_prefattura : $fattura->numero_fattura}}</span>
            </div>
            <div class="m-invoice__item">
                <span class="m-invoice__subtitle">{{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }} per </span>
                <span class="m-invoice__text">{{optional(optional($fattura->societa)->ragioneSociale)->nome}}
                    <br>{{optional(optional($fattura->societa)->ragioneSociale)->indirizzo}} - {{optional(optional($fattura->societa)->ragioneSociale)->cap}} - {{optional(optional(optional($fattura->societa)->ragioneSociale)->localita)->nome}} ({{optional(optional(optional($fattura->societa)->ragioneSociale)->localita)->comune->provincia->sigla}})</span>
            </div>
        </div>
    </div>
</div>