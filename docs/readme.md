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



#EVIDENZE


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

