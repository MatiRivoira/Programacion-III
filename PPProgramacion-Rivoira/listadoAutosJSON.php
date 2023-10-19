<?php
include_once "./clases/auto.php";
use RivoiraMatias\Auto;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo Auto::traerJSON('./archivos/autos.json');
}