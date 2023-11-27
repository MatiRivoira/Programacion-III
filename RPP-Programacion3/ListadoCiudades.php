<?php
include_once "./clases/Ciudad.php";
use RivoiraMatias\Ciudad;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ciudades = Ciudad::traer();
    if (isset($ciudades) && isset($_GET["tabla"]) && $_GET["tabla"] == "mostrar") {
        echo '<h1>Listado de ciudades</h1>';
        echo '<table>';
        echo '<thead>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>POBLACION</th>
                    <th>PAIS</th>
                    <th>FOTO</th>
                    </thead>';
        foreach ($ciudades as $ciudad) {
            echo '<tr>
                      <td>' . $ciudad->id . '</td>
                      <td>' . $ciudad->nombre . '</td>
                      <td>' . $ciudad->poblacion . '</td>
                      <td>' . $ciudad->pais . '</td>
                      <td><img src="./ciudades/imagenes/' . $ciudad->pathFoto . '" alt="ciudad"></td>
                      </tr>';
        }
        echo '</table>';
    } else {
        header('Content-Type: application/json');
        echo json_encode($ciudades);
    }
}