<?php

use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["auto_json"], true);
    if ((new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]))->modificar()) {
        echo "{'exito': true, 'mensaje': El AUTO se modifico correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El AUTO no se modifico correctamente}";
    }
}