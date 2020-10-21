@component('mail::message')
# Avviso di riapertura conteggio

{{$conteggio->commerciale->name}} il conteggio {{$conteggio->titolo}} è stato riaperto

<br>
{{ config('app.name') }}
@endcomponent
