<?php
include_once "./clases/Ciudadano.php";
use RivoiraMatias\Ciudadano;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo json_encode(Ciudadano::traerTodos('./archivos/ciudadanos.json'));
}