<?php
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as ResponseMW;
use Poo\AccesoDatos;

require_once "AccesoDatos.php";
require_once __DIR__ . "/Verificadora.php";

class Usuario
{
    public int $id;
    public string $correo;
    public string $clave;
    public string $nombre;
    public string $apellido;
    public string $foto;
    public string $perfil;
    
    public function traerTodos(Request $request, Response $response, array $args): Response {
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo agregar el usuario (╥︣﹏᷅╥)";
        $objRetorno->dato = "{}";
        $objRetorno->status = 424;

		$listaUsuarios = Usuario::traer();

        if(count($listaUsuarios) > 0){
            $objRetorno->exito = true;
            $objRetorno->mensaje = "Listado de usuarios";
            $objRetorno->dato = json_encode($listaUsuarios);
            $objRetorno->status = 200;
        }
		$newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));

        return $newResponse->withHeader('Content-Type', 'application/json');	
	}

    public static function traer() : array {
        $usuarios = array();
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAcceso->retornarConsulta("SELECT id, correo AS correo, clave AS clave, 
                                                        nombre AS nombre, apellido AS apellido, 
                                                        foto AS foto, perfil AS perfil FROM usuarios");
        $consulta->execute();
        $filas = $consulta->fetchAll();

        foreach($filas as $fila) {
            $usuario = new Usuario();
            $usuario->id = $fila[0];
            $usuario->correo = $fila[1];
            $usuario->clave = $fila[2];
            $usuario->nombre = $fila[3];
            $usuario->apellido = $fila[4];
            $usuario->perfil = $fila[5];
            $usuario->foto = $fila[6];

            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

    public function login(Request $request, Response $response, array $args): Response {
        $parametros = $request->getParsedBody();

        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo encontrar el usuario ( ͡❛ ︵ ͡❛)";
        $objRetorno->status = 424;

		if(isset($parametros['user'])) {
            $objeto = json_decode($parametros['user']);
            $usuario = Usuario::verificar($objeto);

            if($usuario != null) {
                $usuarioData = new Usuario();
                $usuarioData->correo = $usuario->correo;
                $usuarioData->nombre = $usuario->nombre;
                $usuarioData->apellido = $usuario->apellido;
                $usuarioData->perfil = $usuario->perfil;
                $usuarioData->foto = $usuario->foto;

                $data = new stdclass();
                $data->usuario = json_encode($usuarioData);
                $data->alumno = "Rivoira Matias";
                $data->dni_alumno = "45065345";

                $objRetorno->exito = true;
                $objRetorno->mensaje = "Token creado correctamente! (ɔ◔‿◔)ɔ ♥";
                $objRetorno->jwt = Verificadora::crearJWT($data);
                $objRetorno->status = 200;
            }
        }
		$newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));

        return $newResponse->withHeader('Content-Type', 'application/json');	
    }

    public static function verificar($objeto) : Usuario | null | bool {
        $usuario = null;
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAcceso->retornarConsulta( "SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");

        $consulta->bindValue(':correo', $objeto->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $objeto->clave, PDO::PARAM_STR);

        if($consulta->execute()) {
            $usuario = $consulta->fetchObject('Usuario');
        }

        return $usuario;
    }

    public function verificarJWT(Request $request, Response $response, array $args): Response {
        $contenidoAPI = "";
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) {
            $token = $request->getHeader("token")[0];

            $obj = Verificadora::verificarJWT($token);

            if ($obj->verificado) {
                $obj_respuesta->exito = true;
                $obj_respuesta->status = 200;
            }

            $obj_respuesta->mensaje = $obj;
        }


        $contenidoAPI = json_encode($obj_respuesta);

        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function agregarUno(Request $request, Response $response, array $args): Response {
        $parametros = $request->getParsedBody();

        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo agregar el usuario ( ͡❛︵ ͡❛)";
        $objRetorno->status = 418;

        if(isset($parametros["usuario"])){
            $objetousuario = json_decode($parametros["usuario"]);
            $archivos = $request->getUploadedFiles();

            $extension = explode(".", $archivos['foto']->getClientFilename());
            $extension = array_reverse($extension);
            $destino = "./src/fotos/";
            
            $usuario = new usuario();
            $usuario->correo = $objetousuario->correo;
            $usuario->clave = $objetousuario->clave;
            $usuario->nombre = $objetousuario->nombre;
            $usuario->apellido = $objetousuario->apellido;
            $usuario->perfil = $objetousuario->perfil;
            $usuario->foto = $destino . $usuario->correo . "." . $extension[0];

            $archivos['foto']->moveTo("." .  $usuario->foto);

            if($usuario->agregar()){
                $objRetorno->exito = true;
                $objRetorno->mensaje = "Usuario agregado correctamente (ɔ◔‿◔)ɔ ♥";
                $objRetorno->status = 200;
            }

        }

        $newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function agregar() : bool | int {
        $retorno = false;
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAcceso->retornarConsulta("INSERT INTO usuarios(correo, clave, nombre, apellido, perfil, foto)" . "VALUES(:correo, :clave, :nombre, :apellido, :perfil, :foto)");

        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);

        if($consulta->execute()) {
            $retorno = $objAcceso->retornarUltimoIdInsertado();
        }

        return $retorno;
    }

    public static function verificarCorreo($objeto) : bool {
        $retorno = false;
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAcceso->retornarConsulta( "SELECT * FROM usuarios WHERE correo = :correo");
        $consulta->bindValue(':correo', $objeto->correo, PDO::PARAM_STR);
        $consulta->execute();
        $consulta2 = $consulta->rowCount();
        
        if($consulta2 > 0) {
            $retorno = true;
        }
        return $retorno;
    }
}