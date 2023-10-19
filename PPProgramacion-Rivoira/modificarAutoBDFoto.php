<?php

use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["auto_json"], true);
    $foto = $_FILES["foto"];

    $destinoCarpeta = "./autos/imagenes/";
    $hora_actual = date("His");
    $tipoArchivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $nombreImagen = $patente . "." . $hora_actual . "." . $tipoArchivo;
    $destino = $destinoCarpeta . $nombreImagen;

    if (move_uploaded_file($foto["tmp_name"] , $destino)) {
        if ((new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"], $destino))->modificar()) {

            $destinoCarpetaModificados = "./autosModificados/";
            $ubicacionAntigua = autoBD::traerUno($auto["patente"])->pathFoto;
            $tipoArchivo = pathinfo($ubicacionAntigua, PATHINFO_EXTENSION);
            $nombreImagenModificada = $auto['patente'] . ".modificado.{$hora_actual}.{$tipoArchivo}";
            $destinoModificado = $destinoCarpetaModificados . $nombreImagenModificada;

            if (move_uploaded_file($ubicacionAntigua, $destinoModificado)) {
                echo "{'exito': true, 'mensaje': El AUTO se modifico correctamente}";
            } else {
                echo "{'exito': false, 'mensaje': La foto original no se movio correctamente}";
            }
        } else {
            echo "{'exito': false, 'mensaje': El AUTO no se modifico correctamente}";
        }
    } else {
        echo "{'exito': false, 'mensaje': no se pudo modificar la foto}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $autosBorrados = json_decode(file_get_contents("./archivos/autosbd_modificados.txt"), true);
    $html = '<table>
                <tr>
                    <th>Patente</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Precio</th>
                    <th>Foto</th>
                </tr>';
    foreach ($autosBorrados as $auto) {
        $html .= '<tr>
                    <td>' . $auto['patente'] . '</td>' .
                    '<td>' . $auto['marca'] . '</td>' .
                    '<td>' . $auto['color'] . '</td>' .
                    '<td>' . $auto['precio'] . '</td>' .
                    '<td><img src="' . $auto['pathFoto'] . '" alt="Foto" width="100"></td>' .
                 '</tr>';
    }
    $html .= '</table>';
    echo $html;
}