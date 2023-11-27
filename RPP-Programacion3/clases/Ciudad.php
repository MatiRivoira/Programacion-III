<?php
namespace RivoiraMatias;

require_once "./clases/IParte1.php";
require_once "./clases/IParte2.php";

use Exception;
use PDO;
use RivoiraMatias\IParte1;
use RivoiraMatias\IParte2;
use stdClass;

class Ciudad implements IParte1, IParte2
{
    public int $id;
    public string $nombre;
    public int $poblacion;
    public string $pais;
    public string $pathFoto;

    public function __construct(int $id = 0, string $nombre = "", int $poblacion = 0, string $pais = "", string $pathFoto = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->poblacion = $poblacion;
        $this->pais = $pais;
        $this->pathFoto = $pathFoto;
    }

    public function agregar(): bool
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=ciudades_bd", "root", "");
            $sql = $pdo->prepare("INSERT INTO ciudades(nombre, poblacion, pais, path_foto) 
                                            VALUES (:nombre,:poblacion,:pais,:path_foto)");
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':poblacion', $this->poblacion, PDO::PARAM_INT);
            $sql->bindParam(':pais', $this->pais, PDO::PARAM_STR);
            $sql->bindParam(':path_foto', $this->pathFoto, PDO::PARAM_STR);
            if ($sql->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function traer() : array
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=ciudades_bd", "root", "");
            $sql = $pdo->prepare("SELECT * FROM ciudades");
            if ($sql->execute()) {
                $ciudads = $sql->fetchAll();
                $retorno = array();
                if ($ciudads !== false) {
                    foreach ($ciudads as $ciudad) {
                        if (isset($ciudad["path_foto"])) {
                            $retorno[] = new Ciudad($ciudad["id"], $ciudad["nombre"], $ciudad["poblacion"], $ciudad["pais"], $ciudad["path_foto"]);
                        } else {
                            $retorno[] = new Ciudad($ciudad["id"], $ciudad["nombre"], $ciudad["poblacion"], $ciudad["pais"]);
                        }
                    }
                }
                return $retorno;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function existe($ciudades) : bool {
        foreach ($ciudades as $ciudad) {
            if ($ciudad->nombre === $this->nombre && $ciudad->pais === $this->pais) {
                return true;
            }
        }
        return false;
    }

    function modificar(): bool {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=ciudades_bd", "root",""); 
            $sql = $pdo->prepare("UPDATE ciudades SET nombre = :nombre, poblacion = :poblacion, pais = :pais, path_foto = :path_foto WHERE id = :id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':poblacion', $this->poblacion, PDO::PARAM_INT);
            $sql->bindParam(':pais', $this->pais, PDO::PARAM_STR);
            $sql->bindParam(':path_foto', $this->pathFoto, PDO::PARAM_STR);
            if($sql->execute()){
                return true;
            }
            return false;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function eliminar(): bool {
        try {        
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root",""); 
            $sql = $pdo->prepare("DELETE FROM autos WHERE id = :id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            if($sql->execute()){
                return true;
            } else {
                return false;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    
    public static function guardarEnArchivo(Ciudad $ciudad) : string {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al guardar.";

        $nombreFoto = $ciudad->id . ".borrado." . date("His") . ".jpg";
        $nuevoPath = "./ciudadesEliminados/" . $nombreFoto;
        $viejoPath = $ciudad->pathFoto;

        if(rename($viejoPath, $nuevoPath)){
            $ciudad->pathFoto = $nuevoPath;

            $archivo = fopen("./archivos/ciudadbd_borrados.txt", "a");

            $contenidoActual = file_get_contents("./archivos/ciudadbd_borrados.txt");
            $autosEliminados = json_decode($contenidoActual, true);

            if ($autosEliminados === null) {
                $autosEliminados = [];
            }

            array_push($autosEliminados, json_encode($ciudad));

            $contenidoNuevo = json_encode($autosEliminados);
            $resultado = file_put_contents("./archivos/ciudadbd_borrados.txt", $contenidoNuevo);

            fclose($archivo);

            if($resultado){
                $obj->exito = $resultado;
                $obj->mensaje = "Guardado con exito."; 
            }
        }

        return json_encode($obj);
    }

    public static function traerEliminadosBD(){
        $path = "./archivos/ciudadesbd_modificados.txt";
        $ciudadesEliminados = array();

        if(file_exists($path)){
            $contenido = file_get_contents($path);

            $data = json_decode($contenido);
            return $data;
            if($data){
                foreach($data as $linea){
                    $ciudad_json = json_decode($linea);
                    
                    $auto = new Ciudad($ciudad_json->id, $ciudad_json->nombre, $ciudad_json->poblacion, $ciudad_json->pais, $ciudad_json->pathFoto);
                    array_push($ciudadesEliminados, $auto);
                }
            }
        }

        return $ciudadesEliminados;
    }

    public static function traerModificadosBD(){
        $path = "./archivos/ciudadesbd_modificados.txt";
        $ciudadesEliminados = array();

        if(file_exists($path)){
            $contenido = file_get_contents($path);

            $data = json_decode($contenido);
            return $data;
            if($data){
                foreach($data as $linea){
                    $ciudad_json = json_decode($linea);
                    
                    $auto = new Ciudad($ciudad_json->id, $ciudad_json->nombre, $ciudad_json->poblacion, $ciudad_json->pais, $ciudad_json->pathFoto);
                    array_push($ciudadesEliminados, $auto);
                }
            }
        }

        return $ciudadesEliminados;
    }
}
