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

var map = new OpenLayers.Map({
    div: "map",
    layers: [new OpenLayers.Layer.OSM(), m20, m25, m30, m35, m40, m45, m50, m55, m60, m65],
    target: 'map',
    projection: "EPSG:3857",
    center: myLocation.getBounds().getCenterLonLat(),
    zoom: 7
});

$.post( "http://localhost/sismos/", { ini: $('#ini').val(), fin: $('#fin').val(), min:$('#min').val(), max:$('#max').val()})
.done(function( data ) {
    geoData = data;
    refresh(data, $('#fechas').val().split(' hasta ')[0], $('#fechas').val().split(' hasta ')[1], Math.round10(slider.getInfo().left, -1), Math.round10(slider.getInfo().right, -1));
});

function refresh(data, ini, fin, min, max) {
    var count = 0;
    if (data == undefined) return;
    $('#cuenta').text('Buscando eventos sísmicos')
    m20.destroyFeatures();
    m25.destroyFeatures();
    m30.destroyFeatures();
    m35.destroyFeatures();
    m40.destroyFeatures();
    m45.destroyFeatures();
    m50.destroyFeatures();
    m55.destroyFeatures();
    m60.destroyFeatures();
    m65.destroyFeatures();
    for (i=0; i< data.data.length; i++) {
        fec = data.data[i].fecha;
        lon = data.data[i].longitud;
        lat = data.data[i].latitud;
        ubi = data.data[i].ubicacion;
        mag = data.data[i].magnitud;

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
        var feature = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point(lon, lat).transform('EPSG:4326', 'EPSG:3857'), {tooltip: ubi});
        if (mag < 2.5) m20.addFeatures(feature);
        if (mag >= 2.5 && mag < 3.0) m25.addFeatures(feature);
        if (mag >= 3.0 && mag < 3.5) m30.addFeatures(feature);
        if (mag >= 3.5 && mag < 4.0) m35.addFeatures(feature);
        if (mag >= 4.0 && mag < 4.5) m40.addFeatures(feature);
        if (mag >= 4.5 && mag < 5.0) m45.addFeatures(feature);
        if (mag >= 5.0 && mag < 5.5) m50.addFeatures(feature);
        if (mag >= 5.5 && mag < 6.0) m55.addFeatures(feature);
        if (mag >= 6.0 && mag < 6.5) m60.addFeatures(feature);
        if (mag >= 6.5) m65.addFeatures(feature);
        $('#cuenta').text(count+' eventos sísmicos')
    }
}
