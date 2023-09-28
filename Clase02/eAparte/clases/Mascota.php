<?php
namespace Animalitos;

class Mascota
{
    public string $nombre;
    public string $tipo;
    public int $edad;
    

    public function __construct(string $nombre, string $tipo, int $edad = 0) {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->edad = $edad;
    }

    public function toString() : string {
        return $this->nombre . " - " . $this->tipo . " - " . $this->edad;
    }

    static function Mostrar(Mascota $m) : string {
        return $m->toString();
    }

    public function Equals(Mascota $m) : bool {
        if ($this->nombre == $m->nombre && $this->tipo == $m->tipo) {
            return true;
        }
        return false;
    }


}
