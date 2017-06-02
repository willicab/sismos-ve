/*********
    Variables
*********/
var dt = new Date();
var myLocation = new OpenLayers.Geometry.Point(-65.9392558, 9.8310113).transform('EPSG:4326', 'EPSG:3857');
var geoData;

/*********
    Diálogo acerca de...
*********/
$('#acerca').click(function() {
    $('#about-back').fadeIn();
});
$('#about-back').click(function() {
    $('#about-back').fadeOut();
});

/*********
    Selector de rango de fechas
*********/
$('#fechas').dateRangePicker({
    format: 'YYYY-MM-DD',
    separator: ' hasta ',
    startDate: '2008-01-01',
    endDate: dt.toYMD(),
});
$('#fechas').data('dateRangePicker').setDateRange('2008-01-01',dt.toYMD());
$('#fechas').bind('datepicker-change',function(event,obj){
    refresh(geoData, $('#fechas').val().split(' hasta ')[0], $('#fechas').val().split(' hasta ')[1], Math.round10(slider.getInfo().left, -1), Math.round10(slider.getInfo().right, -1));
})
$('#fechas').change(function(){
    refresh(geoData, $('#fechas').val().split(' hasta ')[0], $('#fechas').val().split(' hasta ')[1], Math.round10(slider.getInfo().left, -1), Math.round10(slider.getInfo().right, -1));
});
/*********
    Slider de rango de magnitudes
*********/
var slider = new Slider(document.getElementById('slider'), {
    isDate: false,
    min: 2,
    max: 7,
    start: 2,
    end: 7,
    overlap: true,
});
slider.subscribe('moving', function(data) {
    $('#min').text(Math.round10(data.left, -1));
    $('#max').text(Math.round10(data.right, -1));
});
$('#min').text(Math.round10(slider.getInfo().left, -1));
$('#max').text(Math.round10(slider.getInfo().right, -1));
$('.handle').mouseup(function(){
    refresh(geoData, $('#fechas').val().split(' hasta ')[0], $('#fechas').val().split(' hasta ')[1], Math.round10(slider.getInfo().left, -1), Math.round10(slider.getInfo().right, -1));
});

/*********
    Mostrar el mapa
*********/

var feat = new OpenLayers.Layer.Vector('Overlay');

var map = new OpenLayers.Map({
    div: "map",
    layers: [new OpenLayers.Layer.OSM(), feat],
    target: 'map',
    projection: "EPSG:3857",
    center: myLocation.getBounds().getCenterLonLat(),
    zoom: 7
});

//Add a selector control to the vectorLayer with popup functions
var controls = {
    feat: new OpenLayers.Control.SelectFeature(feat, { onSelect: createPopup, onUnselect: destroyPopup })
};

function createPopup(feature) {
    feature.popup = new OpenLayers.Popup("pop",
        feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(300,110),
        '<div class="markerContent">'+feature.attributes.description+'</div>',
        null,
        false,
        function() {
            controls['feat'].unselectAll();
        }
    );

    feature.popup.closeOnMove = true;
    map.addPopup(feature.popup);
}

function destroyPopup(feature) {
    console.log(feature);
    feature.popup.destroy();
    feature.popup = null;
}

map.addControl(controls['feat']);
controls['feat'].activate();

$.post( baseUrl, { ini: $('#ini').val(), fin: $('#fin').val(), min:$('#min').val(), max:$('#max').val()})
.done(function( data ) {
    geoData = data;
    refresh(data, $('#fechas').val().split(' hasta ')[0], $('#fechas').val().split(' hasta ')[1], Math.round10(slider.getInfo().left, -1), Math.round10(slider.getInfo().right, -1));
});

function refresh(data, ini, fin, min, max) {
    var count = 0;
    if (data == undefined) return;
    $('#cuenta').text('Buscando eventos sísmicos')
    feat.destroyFeatures();
    console.log(controls['feat'].popup);
    for (i=0; i< data.data.length; i++) {
        fec = data.data[i].fecha;
        lon = data.data[i].longitud;
        lat = data.data[i].latitud;
        mag = data.data[i].magnitud;
        ubi = data.data[i].ubicacion;

        var t = fec.split(/[- :]/);
        var d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
        var mi = ini.split(/[- :]/);
        var di = new Date(Date.UTC(mi[0], mi[1]-1, mi[2], 12, 00, 00));
        var ma = fin.split(/[- :]/);
        var da = new Date(Date.UTC(ma[0], ma[1]-1, ma[2], 12, 00, 00));
        if(d<=di) continue;
        if(d>=da) continue;
        if(mag<=min) continue;
        if(mag>=max) continue;
        count++;
        var imgMarker;
        if (mag >= 2 && mag <= 2.4) imgMarker = '2.0';
        if (mag >= 2.5 && mag <= 2.9) imgMarker = '2.5';
        if (mag >= 3 && mag <= 3.4) imgMarker = '3.0';
        if (mag >= 3.5 && mag <= 3.9) imgMarker = '3.5';
        if (mag >= 4 && mag <= 4.4) imgMarker = '4.0';
        if (mag >= 4.5 && mag <= 4.9) imgMarker = '4.5';
        if (mag >= 5 && mag <= 5.4) imgMarker = '5.0';
        if (mag >= 5.5 && mag <= 5.9) imgMarker = '5.5';
        if (mag >= 6 && mag <= 6.4) imgMarker = '6.0';
        if (mag >= 6.5) imgMarker = '65';
        var feature = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point(lon, lat).transform('EPSG:4326', 'EPSG:3857'), {description:'<strong>Fecha: '+fec+'<br>Longitud: '+lon+'<br>Latitud: '+lat+'<br>Magnitud: '+mag+'<br>Ubicación: '+ubi+'</strong>'}, {externalGraphic: 'recursos/img/'+imgMarker+'.png', graphicHeight: 24, graphicWidth: 24, graphicXOffset:-12, graphicYOffset:-12  });
        feat.addFeatures(feature);
        $('#cuenta').text(count+' eventos sísmicos')
    }
}
