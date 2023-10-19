<?php

use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["obj_json"], true);
    if ($auto !== null) {
        $auto = new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]);
        if ($auto->existe()) {
            $autos = $auto->traer();
            foreach ($autos as $value) {
                if ($auto->patente === $value->patente) {
                    echo $value->ToJSON();
                }
            }
        } else {
            echo "{'exito': false, 'mensaje': El Auto no esta en la base de datos}";
        }
    } else {
        echo "el auto_json esta vacio";
    }
}