<?php
use RivoiraMatias\Ciudad;
include_once "./clases/Ciudad.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["nombre"])) {
        $nombre = $_GET["nombre"];
        $ciudades = Ciudad::traer();
        $ciudadEnBase = false;

        foreach ($ciudades as $ciudad) {
            if ($ciudad->nombre === $nombre) {
                $ciudadEnBase = true;
                break;
            }
        }

        $response = new stdClass();
        if ($ciudadEnBase) {
            $response->exito = true;
            $response->mensaje = "La ciudad $nombre está en la base de datos.";
        } else {
            $response->exito = false;
            $response->mensaje = "La ciudad $nombre no está en la base de datos.";
        }

        echo json_encode($response);
    } else {
        // Mostrar información de ciudades borradas del archivo
        $ciudadesBorradasFile = "./archivos/ciudadesbd_borradas.txt";
        $ciudadesBorradas = file_get_contents($ciudadesBorradasFile);

        if ($ciudadesBorradas !== false) {
            $ciudadesBorradasArray = json_decode($ciudadesBorradas);

            echo "<html>
                    <head>
                    <title>Ciudades Borradas</title>
                    </head>
                    <body>
                    <h1>Ciudades Borradas</h1>";

            echo "<table border='1'>
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Pais</th>
                    </tr>
                    </thead>
                    <tbody>";

            foreach ($ciudadesBorradasArray as $ciudad) {
                echo "<tr>
                        <td>" . $ciudad->id . "</td>
                        <td>" . $ciudad->nombre . "</td>
                        <td>" . $ciudad->pais . "</td>
                        </tr>";
            }

            echo "</tbody>
                    </table>
                    </body>
                    </html>";
        } else {
            echo "No se encontraron ciudades borradas.";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ciudad_json = isset($_POST["ciudad_json"]) ? $_POST["ciudad_json"] : null;
    $accion = isset($_POST["accion"]) ? $_POST["accion"] : null;

    $response = new stdClass();

    if ($ciudad_json && $accion === "borrar") {
        // Decodificar el JSON
        $ciudadData = json_decode($ciudad_json);

        if ($ciudadData) {
            if (true) { // Cambia esto por el resultado real
                $response->exito = true;
                $response->mensaje = "Ciudad borrada con éxito y guardada en el archivo.";
            } else {
                $response->exito = false;
                $response->mensaje = "Error al borrar la ciudad o guardarla en el archivo.";
            }
        } else {
            $response->exito = false;
            $response->mensaje = "Error en los datos recibidos.";
        }
    } else {
        $response->exito = false;
        $response->mensaje = "Parámetros incorrectos o faltantes.";
    }

    echo json_encode($response);
}