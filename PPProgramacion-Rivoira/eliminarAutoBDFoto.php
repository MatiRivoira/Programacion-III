<?php

use RivoiraMatias\autoBD;

include_once "./clases/autoDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto = json_decode($_POST["auto_json"], true);
    if (autoBD::Eliminar($auto["patente"])) {
        echo (new autoBD($auto["patente"], $auto["marca"], $auto["color"], $auto["precio"], $auto["pathFoto"]))->guardarEnArchivo();
    } else {
        echo "{'exito': false, 'mensaje': El AUTO no se elimino correctamente}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $autosBorrados = json_decode(file_get_contents("./archivos/autosbd_borrados.txt"), true);
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
