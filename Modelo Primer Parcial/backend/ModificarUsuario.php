<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $id_perfil = $_POST["id_perfil"];
    if ((new Usuario($id, $nombre, $correo, $clave, $id_perfil, "Modificar"))->Modificar()) {
        echo "{'exito': true, 'mensaje': El Usuario se modifico correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El Usuario no se modifico correctamente}";
    }
}