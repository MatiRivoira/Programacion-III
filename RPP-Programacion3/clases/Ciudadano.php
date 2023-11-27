<?php
namespace RivoiraMatias;
use stdClass;

class Ciudadano
{
    public string $ciudad;
    public string $email;
    public string $clave;

    public function __construct(string $email, string $clave, string $ciudad = "") {
        $this->ciudad = $ciudad;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function toJSON() : string{
        $obj = new stdClass();
        $obj->ciudad = $this->ciudad;
        $obj->email = $this->email;
        $obj->clave = $this->clave;
        return json_encode($obj);
    }

    public function guardarEnArchivo(string $path){
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al guardar.";

        $archivo = fopen($path, "a");

        $retorno = fwrite($archivo, $this->toJSON() . "\n\r");

        if($retorno > 0){
            $obj->exito = true;
            $obj->mensaje = "Guardado con éxito.";
        }

        fclose($archivo);
        return json_encode($obj);
    }

    public static function traerTodos($path){
        $ciudadanos = array();

        if(file_exists($path)){
            $contenido = file_get_contents($path);

            if($contenido !== false){
                $lineas = explode("\n\r", $contenido);

                foreach($lineas as $linea){
                    $data = json_decode($linea);

                    if ($data !== null) {
                        $email = isset($data->email) ? (string) $data->email : "";
                        $clave = isset($data->clave) ? (string) $data->clave : "";
                        $ciudad = isset($data->ciudad) ? (string) $data->ciudad : "";
    
                        // Creamos un nuevo objeto Ciudadano
                        $ciudadano = new Ciudadano($email, $clave, $ciudad);
    
                        // Agregamos el objeto Ciudadano al array
                        $ciudadanos[] = $ciudadano;
                    }
                }
            }
        }
        return $ciudadanos;
    }

    public static function verificarExistencia($ciudad, $path){
        $ciudads = Ciudadano::traerTodos($path);
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Ciudadano no encontrado";
        foreach($ciudads as $value){
            if($value->email == $ciudad->email && $value->clave == $ciudad->clave){
                $obj->exito = true;
                $obj->mensaje = "Ciudadano encontrado.";
                break;
            }
        }
        return json_encode($obj);
    }
}
