<?php

use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["auto_json"], true);
    if (autoBD::Eliminar($auto["patente"])) {
        (new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]))->guardarJSON('./archivos/autos_eliminados.json');
        echo "{'exito': true, 'mensaje': El AUTO se elimino correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El AUTO no se elimino correctamente}";
    }
}