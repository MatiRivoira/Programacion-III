<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonRecibido = file_get_contents("php://input");
    $data = json_decode($jsonRecibido, true);
    if ($data !== null) {
        $resultado = Usuario::TraerUno($data);
        var_dump($resultado);
    }
}