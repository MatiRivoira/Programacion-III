<?php
include_once "./clases/Empleado.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $id_perfil = $_POST["id_perfil"];
    $foto = $_FILES["foto"];
    $sueldo = $_POST["sueldo"];
    if ((new Empleado($id, $nombre, $correo, $clave, $id_perfil, "Modificar", $foto, $sueldo))->Modificar()) {
        echo "{'exito': true, 'mensaje': El Usuario se modifico correctamente}";
    } else {
        echo "{'exito': false, 'mensaje': El Usuario no se modifico correctamente}";
    }
} else {
    echo "Es necesario el metodo post";
}