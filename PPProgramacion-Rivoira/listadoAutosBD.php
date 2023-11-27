<?php
include_once "./clases/autoDB.php";
use RivoiraMatias\autoBD;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $autos = autoBD::traer();
    if (isset($autos) && isset($_POST["tabla"]) && $_POST["tabla"] == "mostrar") {
        $html = '<h1>Listado de autos</h1>';
        $html .= '<table>';
        $html .= '<thead>
                    <th>Patente</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Foto</th>
                    </thead>';
        foreach ($autos as $auto) {
            $html .= `<tr>
                      <td>$auto->patente</td>
                      <td>$auto->marca</td>
                      <td>$auto->color</td>
                      <td>$auto->precio</td>
                      <td><img src="./autos/imagenes/$auto->foto" alt="auto"></td>
                      </tr>`;
        }
        echo $html;
    } else {
        echo json_encode(autoBD::traer());
    }
} else {
    echo "se necesita el metodo get";
}