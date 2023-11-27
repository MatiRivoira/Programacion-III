<?php
include_once "./clases/Ciudadano.php";
use RivoiraMatias\Ciudadano;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    $clave = $_POST["clave"];

    echo Ciudadano::verificarExistencia(new Ciudadano($email, $clave), "./archivos/ciudadanos.json");
}