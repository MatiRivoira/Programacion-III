<?php

namespace RivoiraMatias;

interface IParte2{
    public static function eliminar(string $patente) : bool;
    public function modificar() : bool;
}