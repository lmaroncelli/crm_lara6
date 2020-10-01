# Clonare le tabelle delle evidenze ogni anno e metterle tutte prelazionate


$db['default']['username'] = 'alpha';
$db['default']['password'] = 'De3aa3aFahsi';
$db['default']['database'] = 'alpha';



- __ev_tipo_evidenza_2020__ (copia della tabella ev_tipo_evidenza con indici, chiavi e autoincrement e poi inseirsco i valori "INSERT into ev_tipo_evidenza_2020 SELECT * FROM ev_tipo_evidenza ")



- __ev_evidenza_2020__


- __ev_mese_2020__


- __ev_tipo_evidenza_mese_2020__


- __ev_evidenze_mese_2020__




metto le acquistate di quelle "nuove" tutte prelazionate

UPDATE ev_evidenze_mese em
SET em.prelazionata = 1, em.acquistata = 0
WHERE em.acquistata = 1