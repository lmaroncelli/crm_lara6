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