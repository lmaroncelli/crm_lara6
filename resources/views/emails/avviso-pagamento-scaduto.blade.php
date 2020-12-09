@component('mail::message')
Gentile Cliente,<br>
La presente per rammentarLe che è scaduto il termine di pagamento relativo al documento che alleghiamo in copia.<br>
<br>
Le ricordo di effettuare questo pagamento con bonifico bancario intestato a:<br>
{{App\Utility::getBancaIa()['intestatario']}}<br>
Iban: {{App\Utility::getBancaIa()['iban']}}<br>
(Banca {{App\Utility::getBancaIa()['nome']}})<br>
Con l'occasione inviamo cordiali saluti.<br>
<br>
<br>
<br>
--<br>
Sandra Nitto<br>
Responsabile amministrazione<br>
Info-alberghi.com<br>
Via Gambalunga, 81/A - 47921 Rimini, Italia<br>
Tel 0541.29187 Orario 9.00 / 13.00 dal Lun. al Ven.<br>
Web: www.info-alberghi.com<br>
E-mail: sandra@info-alberghi.com<br>
@endcomponent
