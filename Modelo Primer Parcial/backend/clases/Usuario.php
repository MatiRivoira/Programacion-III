<?php
require_once "IBM.php";

class Usuario implements IBM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct(int $id, string $nombre, string $correo, string $clave, int $id_perfil, string $perfil) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function ToJSON() : string {
        $datos = array("nombre" => $this->nombre,
                       "correo" => $this->correo,
                       "clave" => $this->clave);
        return json_encode($datos);
    }

    public function GuardarEnArchivo() : string {
        $path = "./archivos/usuarios.json";
        if (!Usuario::EstaXid($path, $this->id)) {
            $usuarios = json_decode(file_get_contents($path));
            $usuarios[] = $this;
            file_put_contents($path, json_encode($usuarios, JSON_PRETTY_PRINT));
            return json_encode(array("exito" => true, "mensaje" => "Usuario guardado correctamente"));
        }
        return json_encode(array("exito" => false, "mensaje" => "Usuario no guardado correctamente"));
    }

    static function TraerTodosJSON() {
       $archivo = "./archivos/usuarios.json";
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            return $contenido;
        }
        return json_encode(array());
    }

    public function Agregar() : bool {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $correo = $this->correo;
            $clave = $this->clave;
            $nombre = $this->nombre;
            $id_perfil = $this->id_perfil;
            $sql = $pdo->prepare("INSERT INTO `usuarios`(`correo`, `clave`, `nombre`, `id_perfil`) VALUES (:correo, :clave, :nombre, :id_perfil)");
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR,50);
            $sql->bindParam(':clave', $clave, PDO::PARAM_STR,8);
            $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT,10);
            if ($sql->execute()) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function TraerTodos() : ?array {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("SELECT * FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil = perfiles.id");
            if ($sql->execute()) {
                $usuarios = $sql->fetchAll();
                $retorno = array();
                if ($usuarios !== false) {
                    foreach ($usuarios as $usuario) {
                        $retorno[] = new Usuario($usuario["id"], $usuario["nombre"], $usuario["correo"], $usuario["clave"], $usuario["id_perfil"], $usuario["descripcion"]);
                    }
                }
                return $retorno;
            } else {
                return null;
            }
        } catch (PDOException) {
            return null;
        }
    }

    public static function TraerUno($params) : ?Usuario {
        try {
            if (isset($params["correo"]) && isset($params["clave"])) {
                $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
                $sql = $pdo->prepare("SELECT * FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil = perfiles.id WHERE correo = :correo AND clave = :clave");
                $sql->bindParam(":correo", $params["correo"], PDO::PARAM_STR, 50);
                $sql->bindParam(":clave", $params["clave"], PDO::PARAM_STR, 8);
                if ($sql->execute()) {
                    $user = $sql->fetch();
                    if ($user != false) {
                        return new Usuario($user["id"], $user["nombre"], $user["correo"], $user["clave"], $user["id_perfil"], $user["descripcion"]);
                    }
                } else {
                    return null;
                }
            }
        } catch (PDOException) {
            return null;
        }
    }

    public static function EstaXid(string $path, int $id) : bool {
        try {
            $file = fopen($path, 'r');
            if ($file === false) {
                throw new Exception("No se pudo abrir el archivo.");
            }
            while (($linea = fgets($file)) !== false) {
                $usuario = json_decode($linea);
                if (is_object($usuario) && isset($usuario->id) && $usuario->id == $id) {
                    fclose($file);
                    return true;
                }
            }
            fclose($file);
            return false;
        } catch (Exception) {
            return false;
        }
    }

    //METODOS INTERFAZ

    public function Modificar(): bool
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil WHERE id = :id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR,50); 
            $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR,8); 
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT,10);
            if($sql->execute()){
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function Eliminar(int $id) : bool{
        try {        
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("DELETE FROM `usuarios` WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_INT);
            if($sql->execute()){
                return true;
            } else {
                return false;
            }
        } catch(PDOException) {
            return false;
        }
    }
}
