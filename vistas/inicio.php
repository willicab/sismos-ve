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
        </div>
        <div id="about-back">
            <div id="about-dialog">
                <h1>Sismos en Venezuela</h1>
                <p>Página interactiva que muestra los eventos sísmicos reportados por <a href="http://funvisis.gob.ve/" target="_blank">FUNVISIS</a> desde el año 2008.</p>
                <p>Desarrollado por <a href="https://blog.willicab.com.ve" target="_blank">William Cabrera</a> (aka willicab)</p>
                <p>Licencia: <a href="http://www.wtfpl.net/about/" target="_blank">WTFPL</a></p>
                <p>Canal de Telegram: <a href="https://t.me/joinchat/AAAAAEJXSsCWnafdokiAEA" target="_blank">Sismos en Venezuela</a></p>
                <h2>Recursos externos</h2>
                <a href="http://jquery.com" target="_blank">jQuery 3.1.1</a><br>
                <a href="https://openlayers.org/" target="_blank">OpenLayers 2.14</a><br>
                <a href="http://momentjs.com/" target="_blank">Moment.js 2.8.4</a><br>
                <a href="https://github.com/pricelinelabs/omni-slider" target="_blank">omni-slider</a><br>
                <a href="https://github.com/longbill/jquery-date-range-picker" target="_blank">jquery-date-range-picker 0.14.4</a><br>
            </div>
        </div>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/jquery-3.1.1.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/moment.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/omni-slider.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/jquery.daterangepicker.min.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/OpenLayers.js"></script>
        <script src="<?= Flight::get('flight.base_url') ?>recursos/js/utils.js"></script>
        <script>
        var m20 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/2.0.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m25 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/2.5.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m30 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/3.0.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m35 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/3.5.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m40 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/4.0.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m45 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/4.5.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m50 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/5.0.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m55 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/5.5.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m60 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/6.0.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
        var m65 = new OpenLayers.Layer.Vector('Overlay', {
            styleMap: new OpenLayers.StyleMap({
                externalGraphic: '<?= Flight::get('flight.base_url') ?>recursos/img/6.5.png',
                graphicWidth: 24, graphicHeight: 24, graphicYOffset: -24
            })
        });
    </script>
    <script src="<?= Flight::get('flight.base_url') ?>recursos/js/script.js"></script>
</body>
</html>
