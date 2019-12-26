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

        
        per ogni tipo di evidenza:

        - trovo le evidenze di quel tipo


