<?php
namespace Negocios;

include_once "/xampp/htdocs/prog3/Clase02/eAparte/clases/Mascota.php";
use Animalitos\Mascota;

class Guarderia 
{
    public string $nombre;
    public array $mascotas;
    
    public function __construct(string $nombre) {
        $this->nombre = $nombre;
        $this->mascotas = array();
    }

    static function Equals(Guarderia $g, Mascota $m) : bool {
        foreach ($g->mascotas as $mascota) {
            if ($mascota->Equals($m)) {
                return true;
            }
        }
        return false;
    }

    public function Add(Mascota $m) : bool {
        if (!Guarderia::Equals($this, $m)) {
            array_push($this->mascotas, $m);
            return true;
        }
        return false;
    }

    public function __toString() : string
    {
        $sumaEdades = 0;
        $retorno = $this->nombre . ", Las mascotas en al guarderia son:";
        foreach ($this->mascotas as $mascota) {
            $retorno .= "<br>" . $mascota->toString();  
            $sumaEdades += $mascota->edad;        
        }
        $retorno .= "<br> El promedio de edad es: " . ($sumaEdades / count($this->mascotas)); 
        return $retorno;
    }
}