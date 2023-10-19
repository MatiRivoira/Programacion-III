<?php
include_once "./clases/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo Usuario::TraerTodosJSON();
}