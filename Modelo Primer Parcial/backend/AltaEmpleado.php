<?php
require_once "./clases/Empleado.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $id_perfil = $_POST["id_perfil"];
    $foto = $_FILES["foto"];
    $sueldo = $_POST["sueldo"];

    $empleado = new Empleado(0, $nombre, $correo, $clave, $id_perfil, "", $foto, $sueldo);
    if ($empleado->Agregar()) {
        echo "{'exito': true, 'mensaje': El empleado se agrego correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El empleado no se agrego correctamente}";
    }
} else {
    echo "Es necesario el metodo post";
}