<?php
use RivoiraMatias\Ciudad;
include_once "./clases/Ciudad.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ciudad_json = isset($_POST["ciudad_json"]) ? $_POST["ciudad_json"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

    $ciudadData = json_decode($ciudad_json);

    $obj = new stdClass();
    $obj->exito =  false;
    $obj->mensaje = "Error al modificar el ciudad.";

    if($ciudadData){
        foreach(Ciudad::traer() as $ciudad){
            if($ciudad->id == $ciudadData->id){
                $viejoPath = $ciudad->pathFoto;
                break;
            }
        }
        if (isset($viejoPath)) {
            $nuevoPath = $ciudadData->id . ".modificado." . date("His") . ".jpg";

            $ciudad = new Ciudad($ciudadData->id, $ciudadData->nombre, $ciudadData->poblacion, $ciudadData->pais, $nuevoPath);

            $resultado = $ciudad->modificar();

            if($resultado){
                if(rename("./ciudades/fotos/" . $viejoPath, "./ciudadesModificados/" . $nuevoPath)){
                    $obj->exito =  true;
                    $obj->mensaje = "Auto modificado con exito.";
                }
            }      
        } else {
            $obj->exito = false;
            $obj->mensaje = "El ciudad no esta en la base de datos";
        }
    } else {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error en los datos recibidos.";
    }

    echo json_encode($obj);

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ciudadsEliminados = Ciudad::traerModificadosBD();

    echo "<html>
            <head>
            <title>Autos Borrados</title>
            </head>
            <body>
            <h1>Autos Borrados</h1>";

    echo "<table border='1'>
            <thead>
            <tr>
            <th>id</th>
            <th>nombre</th>
            <th>poblacion</th>
            <th>pais</th>
            <th>Foto</th>
            </tr>
            </thead>
            <tbody>";
    
    foreach($ciudadsEliminados as $ciudad){
        echo "<tr>
                <td> . $ciudad->id . </td>
                <td> . $ciudad->nombre . </td>
                <td> . $ciudad->poblacion . </td>
                <td> . $ciudad->pais . </td>
                <td><img src=" . $ciudad->pathFoto .  "width='100'>
                </td>
                </tr>";
    }

    echo "</tbody>
            </table>
            </body>
            </html>";
}
