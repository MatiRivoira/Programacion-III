<?php
use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["auto_json"], true);
    if ($auto !== null) {
        if ((new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]))->agregar()) {
            echo "{'exito': true, 'mensaje': El Auto se agrego correctamente}";
        } else {
            echo "{'exito': false, 'mensaje': El Auto no se agrego correctamente}";
        }
    } else {
        echo "el auto_json esta vacio";
    }
}