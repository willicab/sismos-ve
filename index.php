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

Flight::route('GET /refresh', function(){
    $db = Flight::db();
    for ($i=2008; $i<=2017; $i++) {
        $count = 0;
        $url = "http://www.funvisis.gob.ve/sis_mes.php";
        $params=[
            'select_m'=>$i,
            's_mes'=>'',
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PROXY, "http://proxy.vit.gob.ve:3128/");
        $html = curl_exec($ch);
        curl_close($ch);

        $re = '/<tr>\n[ \t]*<td align=\"center\"><a class=\'lightwindow page-options\' href=\'images\/reportes\/[^.]*.gif\'>([^<]*)<\/a><\/td>\n[ \t]*<td align="center">([^<]*)<\/td>\n[ \t]*<td align="center">([^<]*)<\/td>\n[ \t]*<td align="center">([^<]*)<\/td>\n[ \t]*<td align="center">([^<]*)<\/td>\n[ \t]*<td align="center">([^<]*)<\/td>\n[ \t]*\n[ \t]*<td align=\"center\"><a class=\'lightwindow page-options\' href=\'images\/reportes\/[^.]*.gif\'>([^<]*)<\/a>/';
        preg_match_all($re, $html, $matches, PREG_SET_ORDER, 0);
        print "$i ".count($matches)." resultados\n";
        for ($j = 0; $j < count($matches); $j++) {
            $fecha = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $matches[$j][1])." ".$matches[$j][2]));
            $latitud = $matches[$j][3];
            $longitud = $matches[$j][4];
            $profundidad = $matches[$j][5];
            $magnitud = $matches[$j][6];
            $ubicacion = $matches[$j][7];

            $res = $db->prepare("SELECT id FROM historico WHERE fecha = '$fecha'");
            $res->execute();
            if(!$res->rowCount()){
                $count++;
                $sql = "INSERT INTO historico (fecha, latitud, longitud, profundidad, magnitud, ubicacion) VALUES ";
                $sql .= "(:fecha, :latitud, :longitud, :profundidad, :magnitud, :ubicacion)";
                $insertar_sismo = $db->prepare($sql);
                $insertar_sismo->bindParam(':fecha', $fecha);
                $insertar_sismo->bindParam(':latitud', $latitud);
                $insertar_sismo->bindParam(':longitud', $longitud);
                $insertar_sismo->bindParam(':profundidad', $profundidad);
                $insertar_sismo->bindParam(':magnitud', $magnitud);
                $insertar_sismo->bindParam(':ubicacion', $ubicacion);
                $insertar_sismo->execute();
            }
        }
    }
    Flight::json(array("count"=>$count));
});

Flight::start();
