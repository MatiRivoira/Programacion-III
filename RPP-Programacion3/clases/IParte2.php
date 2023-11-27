<?php
namespace RivoiraMatias;

require_once "./clases/Ciudad.php";
use RivoiraMatias\Ciudad;

interface IParte2{
    public function modificar() : bool;
    public function eliminar() : bool;
    public static function guardarEnArchivo(Ciudad $ciudad) : string;
}