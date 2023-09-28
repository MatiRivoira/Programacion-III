<?php

 abstract class FiguraGeometrica
{
    protected string $_color;
    protected int $_perimetro;
    protected int $_superficie;

    public function __construct() {
        $this->_color = "black";
        $this->_perimetro = 0;
        $this->_superficie = 0;
    }

    public function get_Color() : string {
        return $this->_color;
    }

    public function set_Color(string $_color) : void {
        $this->_color = $_color;
    }

    public function ToString() : string
    {
        return "Color: " . $this->_color . "\nSuperficie: " . $this->_superficie . "\nPerímetro: " . $this->_perimetro;
    }

    public abstract function Dibujar() : string;
    protected abstract function CalcularDatos() : void;
}

class Rectangulo extends FiguraGeometrica 
{
    private int $_ladoDos;
    private int $_ladoUno;

    public function __construct(int $altura, int $ancho) {
        parent::__construct();
        $this->_ladoUno = $altura;
        $this->_ladoDos = $ancho;
    }

    public function Dibujar() : string
    {
        $retorno = "";
        for ($i = 0; $i < $this->_ladoUno; $i++) { 
            for ($j = 0; $j < $this->_ladoDos; $j++) { 
                $retorno .= "*";
            }
            $retorno .= "<br>";
        }
        return $retorno;
    }

    public function CalcularDatos(): void{
        $this->_superficie = $this->_ladoUno * $this->_ladoDos;
        $this->_perimetro = 2 * ($this->_ladoUno + $this->_ladoDos);
    }
}

class Triangulo extends FiguraGeometrica
{
    private int $_altura;
    private int $_base;

    public function __construct(int $altura, int $base) {
        $this->_altura = $altura;
        $this->_base = $base;
    }

    public function Dibujar(): string
    {
        $retorno = "";
        for ($i=0; $i < $this->_altura; $i++) { 
            for ($j=0; $j < $this->_base / 2 - $i; $j++) { 
                $retorno .= "&nbsp";
            }
            $retorno .= "*";
            for ($k=0; $k < $i * 2; $k++) { 
                $retorno .= "*";
            }
            $retorno .= "<br>";
        }
        return $retorno;
    }

    public function CalcularDatos() : void {
        $this->_superficie = ($this->_base * $this->_altura) / 2;
        $this->_perimetro = $this->_base + sqrt(pow($this->_base, 2) + pow($this->_altura, 2)) + $this->_altura;
    }
}


// MAIN
$rectangulo = new Rectangulo(3, 7);
$triangulo = new Triangulo(3, 5);

echo $rectangulo->Dibujar();
echo $triangulo->Dibujar();