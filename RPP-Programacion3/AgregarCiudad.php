<?php
use RivoiraMatias\Ciudad;

include_once "./clases/Ciudad.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST["nombre"];
    $poblacion = $_POST["poblacion"];
    $pais = $_POST["pais"];
    $foto = $_FILES["foto"];
    
    // Define la carpeta de destino para la imagen
    $destinoCarpeta = "./ciudades/fotos/";
    // Genera un nombre único para la imagen
    $hora_actual = date("His");
    $tipoArchivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $nombreImagen = $nombre . "." . $pais . "." . $hora_actual . "." . $tipoArchivo;
    $destino = $destinoCarpeta . $nombreImagen;

    $auto = new Ciudad(0, $nombre, $poblacion, $pais, $nombreImagen);
    if (!$auto->existe(Ciudad::traer())) {
        if ($auto->agregar()) {
            move_uploaded_file($foto["tmp_name"], $destino);
            echo "{'exito': true, 'mensaje': La ciudad se agrego correctamente}";
        } else {
            echo "{'exito': false, 'mensaje': La ciudad no se agrego correctamente}";
        }
    } else {
        echo "{'exito': false, 'mensaje': La ciudad no se agrego correctamente ya que la ciudad se encuentra ya en la base de datos}";
    }
}