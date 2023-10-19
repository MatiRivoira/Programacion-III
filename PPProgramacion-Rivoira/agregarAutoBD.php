<?php
use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patente = $_POST["patente"];
    $marca = $_POST["marca"];
    $color = $_POST["color"];
    $precio = $_POST["precio"];
    $foto = $_FILES["foto"];
    
    // Define la carpeta de destino para la imagen
    $destinoCarpeta = "./autos/imagenes/";
    // Genera un nombre único para la imagen
    $hora_actual = date("His");
    $tipoArchivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $nombreImagen = $patente . "." . $hora_actual . "." . $tipoArchivo;
    $destino = $destinoCarpeta . $nombreImagen;

    $auto = new autoBD($patente, $marca, $color, $precio, $destino);
    if ($auto->existe()) {
        if ($auto->agregar()) {
            move_uploaded_file($foto["tmp_name"], $destino);
            echo "{'exito': false, 'mensaje': El Auto se agrego correctamente}";
        } else {
            echo "{'exito': false, 'mensaje': El Auto no se agrego correctamente}";
        }
    } else {
        echo "El auto ya esta en la base de datos";
    }
}