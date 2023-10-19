<?php
include_once "./clases/auto.php";
use RivoiraMatias\Auto;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patente = $_POST["patente"];

    echo Auto::verificarAutoJSON($patente);
}