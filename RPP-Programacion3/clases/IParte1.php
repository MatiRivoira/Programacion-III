<?php

namespace RivoiraMatias;

interface IParte1{
    public function agregar() : bool;
    public static function traer() : array;
    public function existe($ciudades):bool;
}