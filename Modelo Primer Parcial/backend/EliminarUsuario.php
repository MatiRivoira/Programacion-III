<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    if (Usuario::Eliminar($id)) {
        echo "{'exito': true, 'mensaje': El Usuario se elimino correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El Usuario no se elimino correctamente}";
    }
}