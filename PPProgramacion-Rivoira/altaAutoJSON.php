<?php
include_once "./clases/auto.php";
use RivoiraMatias\Auto;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patente = $_POST["patente"];
    $marca = $_POST["marca"];
    $color = $_POST["color"];
    $precio = $_POST["precio"];

    $auto = new Auto($patente, $marca, $color, $precio);
    echo $auto->guardarJSON('./archivos/autos.json');
}