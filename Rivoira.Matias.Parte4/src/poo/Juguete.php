<?php
require_once "AccesoDatos.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Poo\AccesoDatos;

use function PHPSTORM_META\type;

class Juguete {
    public int $id;
    public string $marca;
    public float $precio;
    public string $pathFoto;

    public function agregarUno(Request $request, Response $response, array $args): Response {
        $parametros = $request->getParsedBody();

        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo agregar el juguete :c";
        $objRetorno->status = 418;

        if (isset($parametros["juguete_json"])) {
            if ($parametros["juguete_json"] !== "") {
                $objJuguete = json_decode($parametros["juguete_json"]);
                $archivos = $request->getUploadedFiles();

                $extension = explode(".", $archivos["foto"]->getClientFilename());
                $extension = array_reverse($extension);
                $destino = "./src/fotos/";
                $juguete = new Juguete();

                $juguete->marca = $objJuguete->marca;
                $juguete->precio = (float)$objJuguete->precio;
                $juguete->pathFoto = $destino . $juguete->marca . "." . $extension[0];
                $archivos['foto']->moveTo("." .  $juguete->pathFoto);

                if ($juguete->agregar()) {
                    $objRetorno->exito = true;
                    $objRetorno->mensaje = "Juguete agregado correctamente (ɔ◔‿◔)ɔ ♥";
                    $objRetorno->status = 200;
                }
            } else {
                $objRetorno->exito = true;
                $objRetorno->mensaje = "Para agregar un juguete, porfavor pasarle parametros (ㆆ_ㆆ)";
                $objRetorno->status = 200;
            }
        }
        $newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function agregar() : bool {
        $retorno = false;
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAcceso->retornarConsulta("INSERT INTO juguetes (marca, precio, path_foto) VALUES(:marca, :precio, :path_foto)");
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', (float)$this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':path_foto', $this->pathFoto, PDO::PARAM_STR);

        if($consulta->execute()) {
            $retorno = true;
        }
        return $retorno;
    }

    public function traerTodos(Request $request, Response $response, array $args): Response {
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo traer la lista :c";
        $objRetorno->tabla = "null";
        $objRetorno->status = 424;
		$listaUsuarios = Juguete::traer();

        if(count($listaUsuarios) > 0) {
            $objRetorno->exito = true;
            $objRetorno->mensaje = "Listado de juguetes";
            $objRetorno->tabla = json_encode($listaUsuarios);
            $objRetorno->status = 200;
        }
		$newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));
        return $newResponse->withHeader('Content-Type', 'application/json');	
	}

    public static function traer() : array {
        $juguetes = array();
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAcceso->retornarConsulta("SELECT id, marca AS marca, precio AS precio, path_foto AS path_foto FROM juguetes");
        $consulta->execute();
        $filas = $consulta->fetchAll();

        foreach($filas as $fila){
            $juguete = new Juguete();
            $juguete->id = $fila[0];
            $juguete->marca = $fila[1];
            $juguete->precio = $fila[2];
            $juguete->pathFoto = $fila[3];

            array_push($juguetes, $juguete);
        }
        return $juguetes;
    }

    public function borrarUno(Request $request, Response $response, array $args): Response {		 
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo eliminar el juguete :c";
        $objRetorno->status = 418;

        if(isset($request->getHeader('token')[0]) && isset($args['id'])){
            $token = $request->getHeader('token')[0];
            if (Verificadora::verificarJWT($token)->verificado) {
                $id = $args['id'];
                $datosToken = Verificadora::obtenerPayLoad($token);
                $usuarioToken = json_decode($datosToken->payload->data->usuario);
                $perfilUsuario = $usuarioToken->perfil;
                if($perfilUsuario == "supervisor"){
                    if(Juguete::borrar($id)){
                        $objRetorno->exito = true;
                        $objRetorno->mensaje = "Juguete eliminado correctamente (ɔ◔‿◔)ɔ ♥";
                        $objRetorno->status = 200;
                    } else {
                        $objRetorno->mensaje = "El juguete no se encuentra en el listado :c";
                    }
                } else {
                    $objRetorno->mensaje = "Su usuario no cuenta con la autorizacion requerida para eliminar juguetes, *$usuarioToken->perfil* (ㆆ_ㆆ)";
                }
            } else {
                $objRetorno->mensaje = "El Token es inválido! ( ͡❛︵ ͡❛)";
            }
        }
        $newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write(json_encode($objRetorno));	
		return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function borrar(int $_id) : bool {
        $retorno = false;
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objAccesoDato->RetornarConsulta("DELETE FROM juguetes WHERE id = :id");	
		$consulta->bindValue(':id', $_id, PDO::PARAM_INT);		
        $consulta->execute();
		if($consulta->rowCount() > 0){
            $retorno = true;
        }
		return $retorno;
	}

    public function modificarUno(Request $request, Response $response, array $args): Response {
        $parametros = $request->getParsedBody();
        $objRetorno = new stdclass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "No se pudo agregar el juguete";
        $objRetorno->status = 418;
        if(isset($request->getHeader('token')[0]) && isset($parametros["juguete"])){
            $token = $request->getHeader('token')[0];
            $objJuguete = json_decode($parametros["juguete"]);
            if ($objJuguete) {
                $archivos = $request->getUploadedFiles();

                //FOTO
                $extension = explode(".", $archivos['foto']->getClientFilename());
                $extension = array_reverse($extension);
                $destino = "./src/fotos/";
            
                $juguete = new Juguete();
                $juguete->id = $objJuguete->id_juguete;
                $juguete->marca = $objJuguete->marca;
                $juguete->precio = (float)$objJuguete->precio;
                $juguete->pathFoto = $destino . $juguete->marca . "_modificacion." . $extension[0];
                $archivos['foto']->moveTo("." .  $juguete->pathFoto);
                
                //TOKEN
                $datosToken = Verificadora::obtenerPayLoad($token);
                $usuarioToken = json_decode($datosToken->payload->data->usuario);
                $perfilUsuario = $usuarioToken->perfil;
                if($perfilUsuario == "supervisor"){
                    if($juguete->modificar()){
                        $objRetorno->exito = true;
                        $objRetorno->mensaje = "Juguete modificado correctamente (ɔ◔‿◔)ɔ ♥";
                        $objRetorno->status = 200;
                    } else {
                        $objRetorno->mensaje = "El juguete no se encuentra en el listado ( ͡❛︵ ͡❛)";
                    }
                } else {
                    $objRetorno->mensaje = "Su usuario no cuenta con la autorizacion requerida para modificar juguetes, *$usuarioToken->perfil* (ㆆ_ㆆ)";
                }
            }
        }
        $newResponse = $response->withStatus($objRetorno->status);
        $newResponse->getBody()->write(json_encode($objRetorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function modificar() : bool {
        $retorno = false;
        $objAcceso = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAcceso->retornarConsulta("UPDATE juguetes SET marca = :marca, precio = :precio, path_foto = :path_foto WHERE id = :id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', (float)$this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':path_foto', $this->pathFoto, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $retorno = true;
        }
        return $retorno;
    }

    public static function traerJuguete(int $id){
		$objetoAcceso = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAcceso->retornarConsulta("SELECT * FROM juguetes WHERE id = :id");
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
        $juguete = $consulta->fetchObject('Juguete');
        $juguete->pathFoto = $juguete->path_foto;
        return $juguete;
    }
}