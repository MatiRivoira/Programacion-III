<?php
require_once "Usuario.php";
require_once "ICRUD.php";

class Empleado extends Usuario implements ICRUD
{
    public array $foto;
    public float $sueldo;

    public function __construct(int $id, string $nombre, string $correo, string $clave, int $id_perfil, string $perfil, array $foto, float $sueldo) {
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    public static function TraerTodos(): array{
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("SELECT * FROM empleados INNER JOIN perfiles ON empleados.id_perfil = perfiles.id");
            if ($sql->execute()) {
                $empleados = $sql->fetchAll();
                $retorno = array();
                if ($empleados !== false) {
                    foreach ($empleados as $empleado) {
                        $retorno[] = new Empleado($empleado["id"], $empleado["nombre"], $empleado["correo"], $empleado["clave"], $empleado["id_perfil"], $empleado["descripcion"], $empleado["foto"], $empleado["sueldo"]);
                    }
                }
                return $retorno;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function Agregar(): bool {
        try {
            $hora_actual = date("His");
            $path = "./empleados/fotos/" . "{$this->nombre}.{$hora_actual}." . pathinfo("./empleados/fotos/" . $this->foto["name"], PATHINFO_EXTENSION);
            if (Empleado::UpdateFoto("./empleados/fotos/", $this->foto, "{$this->nombre}.{$hora_actual}")) {
                $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
                $sql = $pdo->prepare("INSERT INTO empleados(correo, clave, nombre, id_perfil, foto, sueldo) 
                                                    VALUES (:correo,:clave,:nombre,:id_perfil,:foto,:sueldo)");
                $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR,50);
                $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR,8);
                $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR,30);
                $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT,10);
                $sql->bindParam(':foto', $path, PDO::PARAM_STR,50);
                $sql->bindParam(':sueldo', $this->sueldo, PDO::PARAM_INT);
                if ($sql->execute()) {
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function Modificar(): bool {
        try {
            $hora_actual = date("His");
            $path = "";
            if (count($this->foto) > 0) {
                if (Empleado::UpdateFoto("./empleados/fotos/", $this->foto, "{$this->nombre}.{$hora_actual}")) {
                    $path = "./empleados/fotos/" . "{$this->nombre}.{$hora_actual}." . pathinfo("./empleados/fotos/" . $this->foto["name"], PATHINFO_EXTENSION);
                }
            }
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("UPDATE empleados SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil, `foto`= :foto,`sueldo`= :sueldo WHERE id = :id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR,50); 
            $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR,8); 
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT,10);
            $sql->bindParam(':foto', $path, PDO::PARAM_STR,50);
            $sql->bindParam(':sueldo', $this->sueldo, PDO::PARAM_INT);
            if($sql->execute()){
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function Eliminar($id) : bool {
        try {        
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("DELETE FROM `empleados` WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            if($sql->execute()){
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function UpdateFoto(string $carpetaFinal, array $foto, string $nombre) : bool {
        $destino = $carpetaFinal . $foto["name"];
        $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
        $destino = $carpetaFinal . "{$nombre}.{$tipoArchivo}";
        if (move_uploaded_file($foto["tmp_name"] , $destino)) {
            return true;
        } else {
            return false;
        }
    }
}
