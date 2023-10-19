<?php
namespace RivoiraMatias;

class Auto
{
    public string $patente;
    public string $marca;
    public string $color;
    public float $precio;

    public function __construct(string $patente, string $marca, string $color, float $precio) {
        $this->patente = $patente;
        $this->marca = $marca;
        $this->color = $color;
        $this->precio = $precio;
    }

    public function ToJSON() : string {
        $datos = array("patente" => $this->patente,
                       "marca" => $this->marca,
                       "color" => $this->color,
                       "precio" => $this->precio);
        return json_encode($datos);
    }

    public function guardarJSON($path) : string {
        $autos = json_decode(file_get_contents($path));
        $autos[] = $this;
        if (file_put_contents($path, json_encode($autos, JSON_PRETTY_PRINT))) {
            return json_encode(array("exito" => true, "mensaje" => "Auto guardado correctamente"));
        }
        return json_encode(array("exito" => false, "mensaje" => "Auto no guardado correctamente"));
    }

    static function traerJSON($path) {
        if (file_exists($path)) {
            $contenido = file_get_contents($path);
            return $contenido;
        }
        return json_encode(array());
    }

    public static function verificarAutoJSON(string $patente) : string {
        $path = "./archivos/autos.json";
        if (file_exists($path)) {
            $contenido = file_get_contents($path);
            $autos = json_decode( $contenido);
            foreach ($autos as $value) {
                if ($value->patente === $patente) {
                    return json_encode(array("exito" => true, "mensaje" => "Auto verificado correctamente"));
                }
            }
        }
        return json_encode(array("exito" => false, "mensaje" => "Auto no verificado correctamente"));   
    }

    

}
