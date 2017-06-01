<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
#header('Content-Type: application/json');

require 'vendor/autoload.php';
Flight::set('flight.views.path', 'vistas');
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=sismos_ve','root','123456'));
$db = Flight::db();
$db->exec("SET CHARACTER SET utf8");

Flight::route('GET /', function(){
    Flight::render('inicio.php', array('name' => 'Bob'));
});

Flight::route('POST /', function(){
    $db = Flight::db();

    $ini = empty(Flight::request()->data->ini) ? "1=1" : "fecha>='".Flight::request()->data->ini."'";
    $fin = empty(Flight::request()->data->fin) ? "1=1" : "fecha<='".Flight::request()->data->fin."'";
    $min = empty(Flight::request()->data->min) ? "1=1" : "magnitud>=".Flight::request()->data->min;
    $max = empty(Flight::request()->data->max) ? "1=1" : "magnitud<=".Flight::request()->data->max;
    $sql = "SELECT * FROM historico WHERE $ini AND $fin AND $min AND $max";
    $gsent = $db->prepare($sql);
    $gsent->execute();
    $resultado = $gsent->fetchAll(PDO::FETCH_ASSOC);
    Flight::json(array("count"=>count($resultado),"data"=>$resultado));
});

Flight::start();
