<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];

    $idRandom = rand(1, 9999);
    while(Usuario::EstaXid("./archivos/usuarios.json", $idRandom)){
        $idRandom = rand(1, 9999);
    }
    $usuario = new Usuario($idRandom, $nombre, $correo, $clave, $idRandom, "");
    echo $usuario->GuardarEnArchivo();
}