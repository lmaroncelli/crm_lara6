# CODICE


SELECT COLUMN_NAME
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = 'crm' AND TABLE_NAME = 'fogli_servizi';





# Riprendo 26/03/2020


Laravel Framework 6.9.0














Per installare lo scaffolding con Vie e Bootstrap adesso bisogna installare prima questo package

> composer require laravel/ui --dev



> php artisan ui:auth

crea le migation, i controller e le viste per lo scaffold dell'autenticazione

> php artisan ui -- bootstrap
  
  seguito da

> npm install && npm run dev

crea gli asset js e css (jQuery, bootstrap,...)




> npm install --save bootstrap-switch




Installo Free WebApp UI Kit built on top of Bootstrap 4  https://coreui.io/


https://coreui.io/demo/2.0/#main.html

https://github.com/coreui/coreui


npm install @coreui/coreui --save


Usage
CSS
Copy-paste the stylesheet <link> into your <head> before all other stylesheets to load our CSS.

<link rel="stylesheet" href="node_modules/@coreui/coreui/dist/css/coreui.min.css">

JS
Many of our components require the use of JavaScript to function. Specifically, they require jQuery, Popper.js, Bootstrap and our own JavaScript plugins. Place the following <script>s near the end of your pages, right before the closing </body> tag, to enable them. jQuery must come first, then Popper.js, then Bootstrap, and then our JavaScript plugins.

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>



in realtà devo scaricare anche questo package ed includerlo prima di coreui, altrimenti da errore la compilazione degli assets

npm install --save perfect-scrollbar

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    //require('bootstrap-switch');
    require('perfect-scrollbar')
    require('@coreui/coreui/dist/js/coreui.min.js');

} catch (e) {}




installo fontawesome

> npm install --save-dev @fortawesome/fontawesome-free




# A casa

Lo installo su Homestead

luigi@luigihome:~/VirtualProjects$ git clone https://github.com/lmaroncelli/crm_lara6.git
Cloning into 'crm_lara6'...


i collego alla VM e aggiorno con composer

vagrant@homestead:~/VirtualProjects/crm_lara6$ composer update


modifico il file Homestead.yaml 

sites:
    - map: blog.xxx
      to: /home/vagrant/VirtualProjects/blog/public
    - map: crm_lara6.xxx
      to: /home/vagrant/VirtualProjects/crm_lara6/public

databases:
    - blog
    - crm_lara6


e poi 

> vagrant provision


- DB

in locale ho già un DB e lo esporto

mysqldump -uroot -p lara_crm > lara_crm.sql

e lo importo nel DB crm_lara6 della VM

modifico l'hosts 

192.168.10.10   crm_lara6.xxx www.crm_lara6.xxx



# EVIDENZE


La entry delle evidenze è del tipo /evidenze/index/<id_macro>



In base alla macro passata devo creare la griglia corrispondente

    > create_griglia_evidenze($data, $id_macro)
        
        trovo i tipi di evidenza associati alla macro (tblEVTipiEvidenze), trovo i mesi e

        
        > _create_evidenze_mese($id_macro, $tipi_evidenze, $mesi);

            per ogni tipo_evidenza verifico che la tblEVTipiEvidenzeMesi abbia i costi associati per ogni mese (altrimenti li inserisco io a 0)

            verifico che la tabella tblEVEvidenze contenga tante righe di tipo_evidenza quanto è scritto nel campo n_max_visibile della tblEVTipiEvidenze (quindi aggiungo o elimino dei tipi di evidenza in una determinata localita)

        
        > per ogni tipo di evidenza:

          - trovo le evidenze di quel tipo

          - trovo i costi di quel tipo per ogni mese


        > per ogni tipo di evidenza:

          - trovo le evidenze

          > per ogni evidenza

            - interrogo la tblEVEvidenzeMesi x info acquistata, prelazionata, agente, hotel

        
    > disegno della griglia

      __tipi_evidenze__
      Array
      (
          [0] => stdClass Object
              (
                  [id] => 1
                  [id_macro] => 1
                  [nome] => OFFERTE SPECIALI
                  [n_max_visibile] => 8
                  [n_min_mesi] => 3
                  [ordine] => 1
                  [macrotipologia] => OFFERTE
              )

          [1] => stdClass Object
              (
                  [id] => 7
                  [id_macro] => 1
                  [nome] => LAST MINUTE GENERICI
                  [n_max_visibile] => 8
                  [n_min_mesi] => 3
                  [ordine] => 2
                  [macrotipologia] => OFFERTE
              )
          ....


        __costi[id_tipo]__

        Array
        (
            [1] => Array
                (
                    [1] => 50
                    [2] => 80
                    [3] => 150
                    [4] => 150
                    [5] => 180
                    [6] => 180
                    [7] => 180
                    [8] => 150
                    [9] => 120
                    [10] => 50
                    [11] => 80
                    [12] => 80
                )

            [7] => Array
                (
                    [1] => 50
                    [2] => 80
                    [3] => 150
                    [4] => 150
                    [5] => 180
                    [6] => 180
                    [7] => 180
                    [8] => 150
                    [9] => 80
                    [10] => 50
                    [11] => 80
                    [12] => 80
                )




        - loop sui tipi_evidenze

           - per ogni mese visualizzo il costo di quel tipo (1a riga dei costi)
           
           > loop sulle evidenze del tipo id_tipo (ogni evidenza è 1 riga)

              per ogni evidenza visualizzo le info associate (tabella tblEVEvidenzeMesi)





**ATTENZIONE**

https://laracasts.com/discuss/channels/eloquent/eager-loading-pivot-tables

nella griglia faccio un loop sui mesi delle evidenze

$evidenza->mesi e da qui trovo $item_ev_mese->pivot->cliente_id

in realtà dovrei eagerloadare il ciente per avere $cliente->id_info


Devo trasormare la relazione

Ev (*) ------------ (*) EvMese

intrducendo una nuova model EvEvidenzaNelMese


Evidenza (1) ----- (*) EvidenzaNelMese (*) ----- (1) EvidenzaMese


class Evidenza extends Model
{
    public function evidenzeNelMese()
    {
        return $this->hasMany('App\EvidenzaNelMese');
    }
}

class EvidenzaMese extends Model
{
    public function evidenzeNelMese()
    {
        return $this->hasMany('App\EvidenzaNelMese');
    }
}

class EvidenzaNelMese extends Model
{
    protected $table = 'tblEVEvidenzeMesi';

    public function evidenza()
    {
        return $this->belongsTo('App\Evidenza');
    }

    public function mese()
    {
        return $this->belongsTo('App\EvidenzaMese');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
}


OPPURE 

// preparo un array tale che $cliente[id] = id_info senza dover fare sempre la query per ogni cella






**colori commerciali**

i colori associati agli id dei commercili li voglio mettere in un array che condivido con tutte le viste; devo utilizzare un supercontroller oppure un Trait



## seleziona cliente

innanzitutto ci vuole la funzione autocomplete che si trova nel package jqueryUI
installo https://www.npmjs.com/package/jquery-autocomplete via npm


> npm install --save jquery-autocomplete


dalla documetazione:

add this code after </body> in your document.

<link type="text/css" rel="stylesheet" hr­ef="autocomplete.css"/>
<script sr­c="jquery.min.js"></script>
<scri­pt sr­c="autocomplete.js"></script>


aggiungo in bootstrap.js

 require('jquery-autocomplete/jquery.autocomplete.js');

 e

 // jquery-autocomplete
@import '~jquery-autocomplete/jquery.autocomplete.css';

in app.scss

seguito da 

> npm install && npm run dev



Quando ho selezionato il cliente faccio una chiamata ajax per mettere in sessione un array del tipo

 $data_evidenza = array(
    'id_cliente' => $cliente->id,
    'id_info' => $id_info,
    'id_agente' => $id_agente,
    'nome_cliente' => $cliente->nome,
    'nome_agente' => $cliente->commerciale,
    'id_macro' => $id_macro
    );







## click sulle celle

Ogni cella può essere:

- prelazionata (grigia)
- non vendibile (bianca)
- assegnata ad un hotel/commerciale

Ogni cella, a parte quelle non vendibili, ha gli attributi:

data-id-evidenza="" data-id-mese="" data-id-hotel=""

ed ha la classe clickable che ascolta l'ìevento click():

- se non ho in sessione il cliente o il commerciale alert (selzionare il cliente)

- altrimenti, prendo

 id_agente: dalla sessione,
id_cliente:  dalla sessione,
id_evidenza: data attribute,
id_mese: data attribute


e faccio una chiamata ajax (admin/evidenze/assegna_mese_evidenza_ajax) che modifica la tabella evidenze_mese_model





## installo bootstrap editable

https://www.npmjs.com/package/bootstrap-editable/v/1.0.1


> npm install --save bootstrap-editable


aggiungo in bootstrap.js

 require('bootstrap-editable/js/index.js');


 e


@import '~bootstrap-editable/css/bootstrap-editable.css';

in app.scss

seguito da 

> npm install && npm run dev



## parchi e fiere


hanno id_macro rispettivamente -1 e -2







# Contratti digitali


1) cliente esistente

array:8 [▼
  "_token" => "yNjlxjc0UOxBRSddSO6Nz3Sjh7GuHMl68cio8HK7"
  "id_commerciale" => "5"
  "tipo_contratto" => "rinnovo"
  "segnalatore" => null
  "item" => "17 - Hotel Sabrina Rimini - Rimini Mare"
  "cliente" => null
  "fatturazione" => "11"
  "referente" => null
]


aggiungo il datepicker 

lo installao scaricando lo zip dal download builder del sito jQuery UI in cui seleziono solo il datepicker con un tema
aggiungo il css e il js copiando i file nella folder public e linkandoli nel master template




# login page


devo installare le icone 

> npm install @coreui/icons --save

nel file webpack.mix.js con mix lo copio nella public/js 

> mix.copy('node_modules/@coreui/icons/js/svgxuse.min.js','public/js/svgxuse.min.js')



#nav bar 

devo installare le icone

> npm install simple-line-icons --save


importo il file css in resources/sass/app.scss

@import '~simple-line-icons/css/simple-line-icons.css';



# ORDER BY 

https://blog.jgrossi.com/2018/querying-and-eager-loading-complex-relations-in-laravel/
https://reinink.ca/articles/dynamic-relationships-in-laravel-using-subqueries





# 07/09/2020 Upgrade to Laravel 7.0



# 10/09/2020 Memorex Vue component

http://felicianoprochera.com/simple-task-app-with-laravel-5-3-and-vuejs/


https://www.smashingmagazine.com/2020/01/data-components-vue-js/


https://developer.okta.com/blog/2019/01/15/crud-app-laravel-vue



# installo il componnete vue per selezionare la data


https://vcalendar.io/installation.html
https://medium.com/plint-sites/javascript-in-laravel-vue-single-file-components-69be12033d98




# API Resource
https://www.youtube.com/watch?v=x_WMkIKztRQ


# Export CSV

https://codingdriver.com/export-csv-file-in-laravel-example.html



# validation laravel vue component


https://medium.com/@sdkcodes/how-to-display-laravel-validation-errors-in-vue-js-491f7f4afc8f




# Firma PDF

nel composer.json ho aggiunto

 "require": {
        ............... 
        "setasign/setapdf-core": "2.26.0.1122"
    },
    "repositories": [
        {
            "type": "composer",
            "url": "https://www.setasign.com/downloads/"
        }
    ],


autenticazione richiesta: vedi .env



i file sono in vendor/setasign/setapdf-core


SetaPDF Installation
++++++++++++++++++++++++++++
The main files of all SetaPDF components are located in the folder "library/SetaPDF/".

The SetaPDF components come with an own autoload function which will register itself in the spl provided __autoload
stack by simply requiring the Autoload.php file:

    require_once('path/to/library/SetaPDF/Autoload.php');

After that you can use all classes without requiring any file manually.

The documentation and demos folders are not needed for productive usage.



https://laraveldaily.com/how-to-use-external-classes-and-php-files-in-laravel-controller/



in composer.json aggiungo la entry files in modo da non dover più fare nessun include

"autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "files": [
            "vendor/setasign/setapdf-core/library/SetaPDF/Autoload.php"
        ]
    },




# Evidenze nel contratto digitale

> https://crm_lara6.xxx/contratto-digitale/5360/edit


ContrattiDigitaliController@edit ==> resources/views/contratti_digitali/form.blade.php

qui via ajax viene caricata la griglia onLoad

url: "{{ route('crea_griglia_evidenza_contratto_ajax') }}",

$("#evidenze_contratto").html(griglia);


la ContrattiDigitaliController@creaGrigliaEvidenzaContrattoAjax

carica la view evidenze_contratto.blade.php che include 

__@include('evidenze.griglia_evidenze_inc', ['contratto_digitale' => 1])__


TUTTI I JS sono nel file resources/views/contratti_digitali/form.blade.php

dentro __@include('javascript_view.js_griglia')__



# Evidenze da admin selezionando un agente

> http://crm_lara6.xxx/evidenze/1

EvidenzeController@index ==> evidenze/griglia.blade.php 

che include 

l file 

__@include('javascript_view.js_griglia')__

__@include('evidenze.griglia_evidenze_inc')__