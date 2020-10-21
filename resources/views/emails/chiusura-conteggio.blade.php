@component('mail::message')
# Avviso di chiusura conteggio

{{$conteggio->commerciale->name}} ha chiuso il conteggio {{$conteggio->titolo}}


<br>
{{ config('app.name') }}
@endcomponent
