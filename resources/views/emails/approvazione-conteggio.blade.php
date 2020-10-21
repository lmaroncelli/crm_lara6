@component('mail::message')
# Avviso di approvazione conteggio

Il conteggio {{$conteggio->titolo}} è stato approvato


<br>
{{ config('app.name') }}
@endcomponent
