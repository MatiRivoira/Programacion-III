<?php

include_once "./clases/Ciudadano.php";
use RivoiraMatias\Ciudadano;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciudad = $_POST["ciudad"];
    $email = $_POST["email"];
    $clave = $_POST["clave"];

    $auto = new Ciudadano($email, $clave, $ciudad);
    echo $auto->guardarEnArchivo("./archivos/ciudadanos.json");
}