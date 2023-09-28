<?php
namespace Rivoira;

class Alumno 
{
    private string $legajo;
    private string $nombre;
    private string $apellido;
    private string $foto;

    public function __construct(string $legajo, string $nombre, string $apellido, string $foto = "") {
        $this->legajo = $legajo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->foto = $foto;
    }

    static function Agregar(Alumno $alumno) : bool{
        if (!Alumno::EstaXLegajo("./archivos/alumnos.txt", $alumno->legajo, "-")) {
            if (file_put_contents("./archivos/alumnos.txt", $alumno->legajo . " - " .  $alumno->apellido . " - " . $alumno->nombre . "\r\n", FILE_APPEND)) {
                return true;
            }
        }
        return false;
    }

    static function Eliminar(Alumno $alumno) : bool {
        $retorno = false;
        $archivo = fopen("./archivos/alumnos.txt", "r");
        if ($archivo) {
            $legajo = $alumno->legajo;
            $elementosAux = array();

            while (!feof($archivo)) {
                $linea = fgets($archivo);
                $elementosFile = explode("-", $linea); //separo la linea por su -
                $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                if ($elementosFile[0] != "") {
                    $elementosFile[1] = trim($elementosFile[1]);
                    $elementosFile[2] = trim($elementosFile[2]);
                    if ($legajo === $elementosFile[0]) {
                        $retorno = true;
                        continue;
                    } else {
                        array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "\r\n");
                    }
                }
            }
            fclose($archivo);
        }

        $archivo = fopen("./archivos/alumnos.txt", "w");
        if ($archivo) {
            $cant = 0;
            foreach($elementosAux as $item){
                $cant = fwrite($archivo, $item);
            }
            fclose($archivo);
        } else {
            $retorno = false;
        }
        return $retorno;
    }

    static function Modificar(Alumno $alumno) : bool {
        $retorno = false;
        $archivo = fopen("./archivos/alumnos.txt", "r");
            if ($archivo) {
                $legajo = $alumno->legajo;
                $elementosAux = array();

                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    $elementosFile = explode("-", $linea); //separo la linea por su -
                    $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                    if ($elementosFile[0] != "") {
                        $elementosFile[1] = trim($elementosFile[1]);
                        $elementosFile[2] = trim($elementosFile[2]);
                        if ($legajo === $elementosFile[0]) {
                            array_push($elementosAux, "$legajo-" . $alumno->apellido . "-" . $alumno->nombre . "\r\n");
                            $retorno = true;
                        } else {
                            array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "\r\n");
                        }
                    }
                }
                fclose($archivo);
            }

            $archivo = fopen("./archivos/alumnos.txt", "w");
            if ($archivo) {
                $cant = 0;
                foreach($elementosAux as $item){
                    $cant = fwrite($archivo, $item);
                }
                if($cant === 0){
                    $retorno = false;
                }
                fclose($archivo);
            } else {
                $retorno = false;
            }
        return $retorno;
    }

    static function Leer() : string{
        return file_get_contents("./archivos/alumnos.txt");
    }

    static function AgregarAF(Alumno $alumno) : bool{
        if (!Alumno::EstaXLegajo("./archivos/alumnos_foto.txt", $alumno->legajo, "-")) {
            if (file_put_contents("./archivos/alumnos_foto.txt", $alumno->legajo . "-" .  $alumno->apellido . "-" . $alumno->nombre . "-" . $alumno->foto . "\r\n", FILE_APPEND)) {
                return true;
            }
        }
        return false;
    }

    static function EliminarAF(Alumno $alumno) : bool {
        $retorno = false;
        $archivo = fopen("./archivos/alumnos_foto.txt", "r");
        if ($archivo) {
            $legajo = $alumno->legajo;
            $elementosAux = array();

            while (!feof($archivo)) {
                $linea = fgets($archivo);
                $elementosFile = explode("-", $linea); //separo la linea por su -
                $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                if ($elementosFile[0] != "") {
                    $elementosFile[1] = trim($elementosFile[1]);
                    $elementosFile[2] = trim($elementosFile[2]);
                    $elementosFile[3] = trim($elementosFile[3]);
                    if ($legajo === $elementosFile[0]) {
                        $retorno = true;
                        continue;
                    } else {
                        array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "-" . $elementosFile[3] . "\r\n");
                    }
                }
            }
            fclose($archivo);
        }

        $archivo = fopen("./archivos/alumnos_foto.txt", "w");
        if ($archivo) {
            foreach($elementosAux as $item){
                fwrite($archivo, $item);
            }
            fclose($archivo);
        } else {
            $retorno = false;
        }
        return $retorno;
    }

    static function ModificarAF(Alumno $alumno) : bool {
        $retorno = false;
        $archivo = fopen("./archivos/alumnos_foto.txt", "r");
            if ($archivo) {
                $legajo = $alumno->legajo;
                $elementosAux = array();

                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    $elementosFile = explode("-", $linea); //separo la linea por su -
                    $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                    if ($elementosFile[0] != "") {
                        $elementosFile[1] = trim($elementosFile[1]);
                        $elementosFile[2] = trim($elementosFile[2]);
                        $elementosFile[3] = trim($elementosFile[3]);
                        if ($legajo === $elementosFile[0]) {
                            array_push($elementosAux, "$legajo-" . $alumno->apellido . "-" . $alumno->nombre . "-" . $alumno->foto . "\r\n");
                            $retorno = true;
                        } else {
                            array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "-" . $elementosFile[3] . "\r\n");
                        }
                    }
                }
                fclose($archivo);
            }

            $archivo = fopen("./archivos/alumnos_foto.txt", "w");
            if ($archivo) {
                $cant = 0;
                foreach($elementosAux as $item){
                    $cant = fwrite($archivo, $item);
                }
                if($cant === 0){
                    $retorno = false;
                }
                fclose($archivo);
            } else {
                $retorno = false;
            }
        return $retorno;
    }

    static function LeerAF() : string{
        return file_get_contents("./archivos/alumnos_foto.txt");
    }

    static function EstaXLegajo(string $path, string $legajo, string $separador, int $lugarLegajo = 0) : bool {
        $archivo = fopen($path, "r");
        if ($archivo) {
            while (!feof($archivo)) {
                $linea = fgets($archivo);
                $elemento = explode($separador, $linea); //separo la linea por su separador
                $elemento[$lugarLegajo] = trim($elemento[$lugarLegajo]); // saco los espacios en el elemento donde se encuentra el legajo
                if ($legajo === $elemento[$lugarLegajo]) {
                    fclose($archivo);
                    return true;
                    break;
                }
            }
            fclose($archivo);
        }
        return false;
    }

    static function BuscarXLegajoAF(string $legajo) : ?Alumno {
        $archivo = fopen("./archivos/alumnos_foto.txt", "r");
        if ($archivo) {
            while (!feof($archivo)) {
                $linea = fgets($archivo);
                $elemento = explode("-", $linea); //separo la linea por su separador
                $elemento[0] = trim($elemento[0]); // saco los espacios en el elemento donde se encuentra el legajo
                if ($legajo === $elemento[0]) {
                    fclose($archivo);
                    return new Alumno($legajo, $elemento[2], $elemento[1], $elemento[3]);
                    break;
                }
            }
            fclose($archivo);
        }
        return null;
    }

    public function __toString():string
    {
        return $this->legajo . "-" . $this->nombre . "-" . $this->apellido . "-" . $this->foto;
    }
}

