<?php

class Auto
{
    private string $_color;
    private float $_precio;
    private string $_marca;
    private DateTime $_fecha;
    
    public function __construct(string $_marca, string $_color, float $_precio = 0, DateTime $_fecha = new DateTime()) {
        $this->_color = $_color;
        $this->_precio = $_precio;
        $this->_marca = $_marca;
        $this->_fecha = $_fecha;
    }

    public function AgregarImpuestos(float $impuesto) : void {
        $this->_precio += $impuesto;
    }

    static function MostrarAuto(Auto $car) : string {
        return  "Datos del vehiculo: ".
                "<br>Color: " . $car->_color.
                "<br>Precio: " . $car->_precio.
                "<br>Marca: " . $car->_marca.
                "<br>Fecha: " . $car->_fecha->format('Y-m-d');
    }

    static function Equals(Auto $a1, Auto $a2) : bool {
        if ($a1->_marca === $a2->_marca && $a1->_color === $a2->_color) {
            return true;
        }
        return false;
    }

    static function Add(Auto $a1, Auto $a2) : float {
        if (self::Equals($a1, $a2)) {
            return $a1->_precio + $a2->_precio;
        }
        return 0;
    }
}