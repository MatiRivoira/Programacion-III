<?php

use Rectangulo as GlobalRectangulo;

class Punto 
{
    private int $_x;
    private int $_y;

    public function __construct(int $x, int $y) {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function GetX():int{
        return $this->_x;
    }
    
    public function GetY():int{
        return $this->_y;
    }

    public function __toString() : string
    {
        return "X:" . $this->_x . " | Y:" . $this->_y;
    }
}

class Rectangulo
{
    private Punto $_vertice1;
    private Punto $_vertice2;
    private Punto $_vertice3;
    private Punto $_vertice4;
    public float $area;
    public int $ladoDos; //ancho
    public int $ladoUno; //altura
    public float $perimetro;

    public function __construct(Punto $v1, Punto $v3) {
        $this->_vertice1 = $v1;
        $this->_vertice2 = new Punto($v1->GetY(), $v3->GetX());
        $this->_vertice3 = $v3;
        $this->_vertice4 = new Punto($v3->GetY(), $v1->GetX());
        $this->ladoUno = $v1->GetY() - $v3->GetY();
        $this->ladoDos = $v3->GetX() - $v1->GetX();
        $this->area = $this->ladoUno * $this->ladoDos;
        $this->perimetro = ($this->ladoUno + $this->ladoDos) * 2;
    }

    public function Dibujar() : string{
        $retorno = "";
        for ($i=0; $i < $this->ladoUno; $i++) { 
            for ($j=0; $j < $this->ladoDos; $j++) { 
                $retorno .= "*";
            }
            $retorno .= "<br>";
        }
        return $retorno;
    }

    public function __toString() : string
    {
        return "DATOS DEL RECTANGULO: " . 
               "<br>Vertice 1: " . $this->_vertice1->__toString().
               "<br>Vertice 2: " . $this->_vertice2->__toString().
               "<br>Vertice 3: " . $this->_vertice3->__toString().
               "<br>Vertice 4: " . $this->_vertice4->__toString().
               "<br>Area: " . $this->area.
               "<br>Perimetro: " . $this->perimetro.
               "<br>Altura: " . $this->ladoUno.
               "<br>Ancho: " . $this->ladoDos;
    }
}

$rectangulo = new Rectangulo(new Punto(0, 3), new Punto(5, 0));
echo $rectangulo->Dibujar();
echo "<br><br>" . $rectangulo->__toString();
