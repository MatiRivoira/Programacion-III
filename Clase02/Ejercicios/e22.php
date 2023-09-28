<?php
include_once "e21.php";

class Garage 
{
    private string $_razonSocial;
    private float $_precioPorHora;
    private $_autos;

    public function __construct(string $_razonSocial, float $_precioPorHora = 0) {
        $this->_razonSocial = $_razonSocial;
        $this->_precioPorHora = $_precioPorHora;
        $this->_autos = array();
    }

    public function MostrarGarage() : string {
        $retorno =  "Datos del garage:" .
                    "<br>Razon social: " . $this->_razonSocial.
                    "<br>Precio por hora: " . $this->_precioPorHora.
                    "<br>Autos aparcados en el garage: ";
        $aux = 1;
        foreach ($this->_autos as $auto) {
            $retorno .= "<br>Plaza N°" . $aux;
            $retorno .= "<br>" . Auto::MostrarAuto($auto);
            $aux++;
        }
        return $retorno;
    }

    static function Equals(Garage $g1, Auto $a1) : bool {
        foreach ($g1->_autos as $auto) {
            if (Auto::Equals($auto, $a1)) {
                return true;
            }
        }
        return false;
    }

    public function Add(Auto $auto) : bool {
        if (!self::Equals($this, $auto)) {
            $this->_autos[] = $auto;
            return true;
        }
        return false;
    }

    public function Remove(Auto $a) : bool {
        foreach ($this->_autos as $key => $auto) {
            if (Auto::Equals($auto, $a)) {
                unset($this->_autos[$key]);
                return true;
            }
        }
        return false;
    }
}