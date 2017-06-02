<!DOCTYPE html>
<html>
    <head>
        <title>Sismos en Venezuela</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= Flight::get('flight.base_url') ?>recursos/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= Flight::get('flight.base_url') ?>recursos/css/daterangepicker.min.css">
    </head>
    <body>
        <div id="map" class="map"></div>
        <a href="https://github.com/willicab/sismos-ve" class="github-corner" aria-label="View source on Github" style="position:absolute;top:0;left:0;z-index:1001" target="_blank"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#151513; color:#fff; position: absolute; top: 0; border: 0; left: 0; transform: scale(-1, 1);" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style></a>
        <div id="caja">
            <h1>Sismos en Venezuela</h1>
            <p>Rango de fechas</p>
            <input type="text" id="fechas">
            <div class="container">
              <div class="fly-search-filters-time-title">
                Magnitud <strong id="min" class="min"></strong><strong class="to"> - a - </strong><strong id="max" class="max"></strong>
              </div>
              <div id="slider" class="fly wrap"></div>
            </div>
            <p id="cuenta">Buscando eventos sísmicos</p>
            <p id="acerca">Acerca de...</p>
            <h2>Leyenda</h2>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/2.0.png"> Magnitud 2.0 a 2.4</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/2.5.png"> Magnitud 2.5 a 2.9</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/3.0.png"> Magnitud 3.0 a 3.4</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/3.5.png"> Magnitud 3.5 a 3.9</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/4.0.png"> Magnitud 4.0 a 4.4</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/4.5.png"> Magnitud 4.5 a 4.9</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/5.0.png"> Magnitud 5.0 a 5.4</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/5.5.png"> Magnitud 5.5 a 5.9</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/6.0.png"> Magnitud 6.0 a 6.4</p>
            <p class="leyenda"><img src="<?= Flight::get('flight.base_url') ?>recursos/img/6.5.png"> Magnitud 6.5 a 6.9</p>
        </div>
        <div id="about-back">
            <div id="about-dialog">
                <h1>Sismos en Venezuela</h1>
                <p>Página interactiva que muestra los eventos sísmicos reportados por <a href="http://funvisis.gob.ve/" target="_blank">FUNVISIS</a> desde el año 2008.</p>
                <p>Desarrollado por <a href="https://blog.willicab.com.ve" target="_blank">William Cabrera</a> (aka willicab)</p>
                <p>Código fuente: <a href="https://github.com/willicab/sismos-ve" target="_blank">https://github.com/willicab/sismos-ve</a></p>
                <p>Licencia: <a href="http://www.wtfpl.net/about/" target="_blank">WTFPL</a></p>
                <p>Canal de Telegram: <a href="https://t.me/joinchat/AAAAAEJXSsCWnafdokiAEA" target="_blank">Sismos en Venezuela</a></p>
                <h2>Recursos externos</h2>
                <a href="http://flightphp.com" target="_blank">Flight PHP 1.3</a><br>
                <a href="http://jquery.com" target="_blank">jQuery 3.1.1</a><br>
                <a href="https://openlayers.org/" target="_blank">OpenLayers 2.14</a><br>
                <a href="http://momentjs.com/" target="_blank">Moment.js 2.8.4</a><br>
                <a href="https://github.com/pricelinelabs/omni-slider" target="_blank">omni-slider</a><br>
                <a href="https://github.com/longbill/jquery-date-range-picker" target="_blank">jquery-date-range-picker 0.14.4</a><br>
            </div>
        </div>
        <script>baseUrl = "<?= Flight::get('flight.base_url') ?>";</script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/jquery-3.1.1.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/moment.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/omni-slider.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/jquery.daterangepicker.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/OpenLayers.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/utils.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/script.js"></script>
    </body>
</html>
