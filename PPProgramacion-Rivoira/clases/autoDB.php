<?php
namespace RivoiraMatias;

require_once "auto.php";
require_once "IParte1.php";
require_once "IParte2.php";
require_once "IParte3.php";

use Exception;
use RivoiraMatias\Auto;
use PDO;
use RivoiraMatias\IParte1;
use RivoiraMatias\IParte2;
use RivoiraMatias\IParte3;

class autoBD extends Auto implements IParte1, IParte2, IParte3
{
    public string $pathFoto;

    public function __construct(string $patente, string $marca, string $color, float $precio = 0, string $pathFoto = "") {
        parent::__construct($patente, $marca, $color, $precio);
        $this->pathFoto = $pathFoto;
    }

    public function agregar() : bool
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
            $sql = $pdo->prepare("INSERT INTO autos(patente, marca, color, precio, foto) 
                                            VALUES (:patente,:marca,:color,:precio,:foto)");
            $sql->bindParam(':patente', $this->patente, PDO::PARAM_STR,30);
            $sql->bindParam(':marca', $this->marca, PDO::PARAM_STR,30);
            $sql->bindParam(':color', $this->color, PDO::PARAM_STR,15);
            $sql->bindParam(':precio', $this->precio, PDO::PARAM_INT);
            $sql->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR,50);
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
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
            $sql = $pdo->prepare("SELECT * FROM autos");
            if ($sql->execute()) {
                $autos = $sql->fetchAll();
                $retorno = array();
                if ($autos !== false) {
                    foreach ($autos as $auto) {
                        if (isset($auto["foto"])) {
                            $retorno[] = new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"], $auto["foto"]);
                        } else {
                            $retorno[] = new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]);
                        }
                    }
                }
                return $retorno;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function traerUno(string $patente) : autoBD
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
            $sql = $pdo->prepare("SELECT * FROM autos WHERE patente = :patente");
            $sql->bindParam(":patente", $patente, PDO::PARAM_STR,30);
            if ($sql->execute()) {
                $autos = $sql->fetchAll();
                $retorno = array();
                if ($autos !== false) {
                    foreach ($autos as $auto) {
                        if (isset($auto["foto"])) {
                            $retorno = new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"], $auto["foto"]);
                        } else {
                            $retorno = new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"]);
                        }
                    }
                }
                return $retorno;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar(string $patente) : bool{
        try {        
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root",""); 
            $sql = $pdo->prepare("DELETE FROM autos WHERE patente = :patente");
            $sql->bindParam(":patente", $patente, PDO::PARAM_STR,30);
            if($sql->execute()){
                return true;
            } else {
                return false;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function modificar(): bool
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root",""); 
            $sql = $pdo->prepare("UPDATE autos SET marca = :marca, color = :color, precio = :precio, foto = :foto WHERE patente = :patente");
            $sql->bindParam(':patente', $this->patente, PDO::PARAM_STR,30);
            $sql->bindParam(':marca', $this->marca, PDO::PARAM_STR,30);
            $sql->bindParam(':color', $this->color, PDO::PARAM_STR,15);
            $sql->bindParam(':precio', $this->precio, PDO::PARAM_INT);
            $sql->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR,50);
            if($sql->execute()){
                return true;
            }
            return false;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function existe() : bool {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root",""); 
            $sql = $pdo->prepare("SELECT * FROM autos WHERE patente = :patente");
            $sql->bindParam(':patente', $this->patente, PDO::PARAM_STR,30);
            if($sql->execute()){
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return true;
                }
            }
            return false;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function guardarEnArchivo(): string {
        $destinoCarpeta = "./autosBorrados/";
        // Genera un nombre único para la imagen
        $hora_actual = date("His");
        $nombreImagen = $this->patente . '.borrado.' . $hora_actual . '.jpg';
        $destino = $destinoCarpeta . $nombreImagen;
        if (move_uploaded_file($this->pathFoto, $destino)) {
            $autos = json_decode(file_get_contents("./archivos/autosbd_borrados.txt"));
            $this->pathFoto = $destino;
            $autos[] = $this;
            if (file_put_contents("./archivos/autosbd_borrados.txt", json_encode($autos, JSON_PRETTY_PRINT))) {
                return json_encode(array("exito" => true, "mensaje" => "Auto guardado correctamente"));
            }
            return json_encode(array("exito" => false, "mensaje" => "Auto no guardado correctamente"));
        } else {
            return json_encode(array("exito" => false, "mensaje" => "No se pudo mover la imagen"));
        }
    }
}
