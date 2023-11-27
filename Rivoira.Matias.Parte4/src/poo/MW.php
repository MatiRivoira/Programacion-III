<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "AccesoDatos.php";
require_once __DIR__ . "/Verificadora.php";

class MW {
    public static function ValidarParametrosVacios(Request $request, RequestHandler $handler): ResponseMW {
        $contenidoAPI = "";
        $parametros = $request->getParsedBody();
        $objRetorno = new stdclass();
        $objRetorno->mensaje = "Hay un parametro vacio :o";
        $objRetorno->status = 409;
        if(isset($parametros['user']) || isset($parametros['usuario'])){
            $objUsuario = isset($parametros['user']) != null ? json_decode($parametros['user']) : json_decode($parametros['usuario']);
            if($objUsuario){
                if($objUsuario->correo != "" && $objUsuario->clave != ""){
                    $response = $handler->handle($request);
                    $contenidoAPI = (string) $response->getBody();
                    $api_respuesta = json_decode($contenidoAPI);
                    $objRetorno->status = $api_respuesta->status;
                } else {
                    $mensajeError = "Parametros vacios: ";
                    if($objUsuario->correo == ""){
                        $mensajeError.= "correo - ";
                    }
                    if($objUsuario->clave == ""){
                        $mensajeError.= "clave";
                    }
                    $objRetorno->mensaje = $mensajeError;
                    $contenidoAPI = json_encode($objRetorno);
                }
            }
        } else {
            $objRetorno->mensaje = "No se recibio el parametro correspondiente (ㆆ_ㆆ)";
            $contenidoAPI = json_encode($objRetorno);
        }
        $response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarCorreoYClaveExistentes(Request $request, RequestHandler $handler): ResponseMW {
        $parametros = $request->getParsedBody();
        $objRetorno = new stdclass();
        $objRetorno->mensaje = "El correo y la clave no estan registrados :|";
        $objRetorno->status = 403;
        $objUsuario = null;
        if(isset($parametros['user'])){
            $objUsuario = json_decode($parametros['user']);
            if(Usuario::verificar($objUsuario)){
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $objRetorno->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($objRetorno);
            } 
        }
        $response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarToken(Request $request, RequestHandler $handler): ResponseMW {
        $contenidoAPI = "";
        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->status = 403;
        if (isset($request->getHeader("token")[0])){
            $token = $request->getHeader("token")[0];
            $obj = Verificadora::verificarJWT($token);
            if ($obj->verificado){
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $objRetorno->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($objRetorno);
            }
            $objRetorno->mensaje = $obj;
        }
        $response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function ListarTablaUsuariosGet(Request $request, RequestHandler $handler): ResponseMW {
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo traer la lista :c";
        $objRetorno->tabla = "null";
        $objRetorno->status = 424;
		$listaUsuarios = Usuario::traer();

        if(count($listaUsuarios) > 0) {
            foreach($listaUsuarios as $usuario) {
                unset($usuario->clave);
            }
            $objRetorno->exito = true;
            $objRetorno->mensaje = "Tabla de Usuarios";
            $objRetorno->tabla = MW::ArmarTabla($listaUsuarios, "<tr><th>ID</th><th>CORREO</th><th>NOMBRE</th><th>APELLIDO</th><th>FOTO</th><th>PERFIL</th></tr>");
            $objRetorno->status = 200;
        }
		$response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write(json_encode($objRetorno));
        return $response->withHeader('Content-Type', 'application/json');	
    }

    public static function ListarTablaUsuariosPost(Request $request, RequestHandler $handler): ResponseMW {
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo listar";
        $objRetorno->status = 403;
        if(isset($request->getHeader('token')[0])){
            $token = $request->getHeader('token')[0];
            $datosToken = Verificadora::obtenerPayLoad($token);
            $usuarioToken = json_decode($datosToken->payload->data->usuario);
            $perfilUsuario = $usuarioToken->perfil;

            if($perfilUsuario == "propietario") { 
                $listaUsuarios = Usuario::traer();
                if(count($listaUsuarios) > 0) {
                    foreach($listaUsuarios as $usuario) {
                        unset($usuario->id);
                        unset($usuario->clave);
                        unset($usuario->foto);
                        unset($usuario->perfil);
                    }
                    $objRetorno->exito = true;
                    $objRetorno->mensaje = "Listado usuarios";
                    $objRetorno->tabla = MW::ArmarTabla($listaUsuarios, "<tr><th>CORREO</th><th>NOMBRE</th><th>APELLIDO</th></tr>");
                    $objRetorno->status = 200;
                }
            } else {
                $objRetorno->mensaje = "Su usuario no cuenta con la autorizacion requerida para Listar la tabla de Usuarios, *$usuarioToken->perfil* (ㆆ_ㆆ)";
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write(json_encode($objRetorno));

        return $response->withHeader('Content-Type', 'application/json');	
    }

    public function ListarTablaJuguetesGet(Request $request, RequestHandler $handler): ResponseMW {
        $listaJuguetesImpares = array();
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo traer la lista :c";
        $objRetorno->tabla = "null";
        $objRetorno->status = 424;
		$listaJuguetes = Juguete::traer();

        if(count($listaJuguetes) > 0) {
            foreach($listaJuguetes as $juguete) {
                if($juguete->id % 2 != 0) {
                    array_push($listaJuguetesImpares, $juguete);
                }
            }

            $objRetorno->exito = true;
            $objRetorno->mensaje = "Tabla de juguetes";
            $objRetorno->tabla = MW::ArmarTabla($listaJuguetesImpares, "<tr><th>ID</th><th>MARCA</th><th>PRECIO</th><th>FOTO</th></tr>");
            $objRetorno->status = 200;
        }

		$response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write(json_encode($objRetorno));

        return $response->withHeader('Content-Type', 'application/json');	
    }

    public static function ArmarTabla(array $lista, string $header) : string {
        $tabla = '<table class="table table-hover">';
        $tabla .= $header;
        foreach($lista as $item){
            $tabla .= "<tr>";
            foreach ($item as $key => $value){
                if ($key == "perfil") {
                    $tabla .= "<td><img src='{$value}' width=25px></td>";
                } else {
                    $tabla .= "<td>{$value}</td>";
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function ValidarCorreoNoExistente(Request $request, RequestHandler $handler): ResponseMW {
        $parametros = $request->getParsedBody();

        $objRetorno = new stdclass();
        $objRetorno->mensaje = "El correo ya existe :|";
        $objRetorno->status = 403;
        $objUsuario = null;

        if(isset($parametros['usuario'])){
            $objUsuario = json_decode($parametros['usuario']);
            if(!Usuario::verificarCorreo($objUsuario)){
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $objRetorno->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($objRetorno);
                
            } 
        }
        $response = new ResponseMW();
        $response = $response->withStatus($objRetorno->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }
}