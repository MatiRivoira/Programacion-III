<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $id_perfil = $_POST["id_perfil"];

    $usuario = new Usuario(0, $nombre, $correo, $clave, $id_perfil, "");
    if ($usuario->Agregar()) {
        echo "{'exito': true, 'mensaje': El Usuario se agrego correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El Usuario no se agrego correctamente}";
    }
}