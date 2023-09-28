<?php

class Pasajero
{
    private string $_apellido;
    private string $_nombre;
    private string $_dni;
    private bool $_esPlus;

    public function __construct(string $_apellido, string $_nombre, string $_dni, bool $_esPlus) {
        $this->_apellido = $_apellido;
        $this->_nombre = $_nombre;
        $this->_dni = $_dni;
        $this->_esPlus = $_esPlus;
    }

    public function Equals(Pasajero $p) : bool {
        if ($this->_dni === $p->_dni) {
            return true;
        }
        return false;
    }

    public function GetInfoPasajero() : string {
        return "Apellido: " . $this->_apellido . " | Nombre: " . $this->_nombre . " | DNI: " . $this->_dni . " | EsPlus: " . $this->_esPlus;
    }

    public function MostrarPasajero() : void {
        echo "<br>Los datos del pasajero son: <br>" . $this->GetInfoPasajero();
    }
}

class Vuelo 
{
    private DateTime $_fecha;
    private string $_empresa;
    private float $_precio;
    private $_listaPasajeros;
    private int $_cantMaxima;

    public function __construct(string $_empresa, float $_precio, int $_cantMaxima = -1) {
        $this->_empresa = $_empresa;
        $this->_precio = $_precio;
        $this->_listaPasajeros = array();
        $this->_cantMaxima = $_cantMaxima;
        $this->_fecha = new DateTime();
    }

    public function GetInformacion() : string {
        $retorno = "Fecha: " . $this->_fecha . " | Empresa: " . $this->_empresa . " | Precio: " . $this->_precio . " | Cantidad maxima pasajeros: ". $this->_cantMaxima;
        $retorno .= "<br>La lista de pasajeros es: ";
        $aux = 1;
        foreach ($this->_listaPasajeros as $pasajero) {
            $retorno .= "Pasajero N°" . $aux;
            $retorno .= $pasajero->GetInfoPasajero();
            $aux++;
        }
        return $retorno;
    }

    public function AgregarPasajero(Pasajero $p1) : string {
        foreach ($this->_listaPasajeros as $item) {
            if ($item == $p1) {
                return "El pasajero ya esta en la lista";
            }
        }
        $this->_listaPasajeros = $p1;
        return "El pasajero fue agregado correctamente";
    }

    private function HayEspacio()
    {
        return count($this->_listaPasajeros) < $this->_cantMaxima || $this->_cantMaxima === 0;
    }

    public function MostrarVuelo()
    {
        echo "Información del Vuelo:<br>";
        echo "Fecha: " . $this->_fecha->format('Y-m-d') . "<br>";
        echo "Empresa: " . $this->_empresa . "<br>";
        echo "Precio: $" . $this->_precio . "<br>";
        echo "Cantidad Máxima de Pasajeros: " . $this->_cantMaxima . "<br>";
        echo "Información de Pasajeros:<br>";
        foreach ($this->_listaPasajeros as $pasajero) {
            $pasajero->MostrarPasajero();
        }
    }

    public static function Add(Vuelo $v1, Vuelo $v2) : float {
        $precioTotal = 0;
        foreach ($v1->_listaPasajeros as $pasajero) {
            if ($pasajero->_esPlus) {
                $precioTotal += $v1->_precio * 0.8;
            } else {
                $precioTotal += $v1->_precio;
            }
        }
        foreach ($v2->_listaPasajeros as $pasajero) {
            if ($pasajero->_esPlus) {
                $precioTotal += $v2->_precio * 0.8;
            } else {
                $precioTotal += $v2->_precio;
            }
        }
        return $precioTotal;
    }

    public function Remove(Pasajero $p) : string {
        foreach ($this->_listaPasajeros as $key => $pasajero) {
            if ($p->Equals($pasajero)) {
                unset($this->_listaPasajeros[$key]);
                return true;
            }
        }
        return false;
    }
}
