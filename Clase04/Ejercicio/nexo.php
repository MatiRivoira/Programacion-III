<?php

// PARTE 1 && PARTE 3 && PARTE 4 && PARTE 5
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (strtolower($_POST["accion"])) {

        case 'agregar':
            if (file_put_contents("./archivos/alumnos.txt", $_POST["legajo"] . " - " .  $_POST["apellido"] . " - " . $_POST["nombre"] . "\r\n", FILE_APPEND)) {
                echo "Datos agregados correctamente";
            } else {
                echo "Algo salio mal!";
            }
            break; 

        case 'verificar':
            $legajo = $_POST['legajo'];
            $archivo = fopen("./archivos/alumnos.txt", "r");
            $encontrado = false;
            if ($archivo) {
                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    $elementosFile = explode("-", $linea); //separo la linea por su -
                    $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                    if ($legajo === $elementosFile[0]) {
                        echo 'El alumno con legajo ' . $legajo . ' se encuentra en el listado';
                        $encontrado = true;
                        break;
                    }
                }
                if (!$encontrado) {
                    echo 'El alumno con legajo ' . $legajo . ' no se encuentra en el listado';
                }
                fclose($archivo);
            }
            break;

        case 'modificar':
            $archivo = fopen("./archivos/alumnos.txt", "r");
            if ($archivo) {
                $legajo = $_POST['legajo'];
                $elementosAux = array();

                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    $elementosFile = explode("-", $linea); //separo la linea por su -
                    $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                    if ($elementosFile[0] != "") {
                        $elementosFile[1] = trim($elementosFile[1]);
                        $elementosFile[2] = trim($elementosFile[2]);
                        $borrado = false;
                        if ($legajo === $elementosFile[0]) {
                            array_push($elementosAux, "$legajo-" . $_POST['apellido'] . "-" . $_POST['nombre'] . "\r\n");
                            $borrado = true;
                        } else {
                            array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "\r\n");
                        }
                    }
                }
                fclose($archivo);
            }

            $archivo = fopen("./archivos/alumnos.txt", "w");
            if ($archivo) {
                $cant = 0;
                foreach($elementosAux as $item){
                    $cant = fwrite($archivo, $item);
                }
                if($cant > 0)
                {
                    if ($borrado) {
                        echo 'El alumno con legajo ' . $legajo . ' se ha borrado'; 
                    } else {
                        echo 'El alumno con legajo ' . $legajo . ' no se ha borrado';
                    }
                } else {
                    echo 'Algo salio mal!';
                }
                fclose($archivo);
            }
            break;
        
        case 'borrar':
            $archivo = fopen("./archivos/alumnos.txt", "r");
            if ($archivo) {
                $legajo = $_POST['legajo'];
                $elementosAux = array();

                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    $elementosFile = explode("-", $linea); //separo la linea por su -
                    $elementosFile[0] = trim($elementosFile[0]); // saco los espacios en el elemento donde se encuentra el legajo
                    if ($elementosFile[0] != "") {
                        $elementosFile[1] = trim($elementosFile[1]);
                        $elementosFile[2] = trim($elementosFile[2]);
                        $borrado = false;
                        if ($legajo === $elementosFile[0]) {
                            $borrado = true;
                            continue;
                        } else {
                            array_push($elementosAux, $elementosFile[0] . "-" . $elementosFile[1] . "-" . $elementosFile[2] . "\r\n");
                        }
                    }
                }
                fclose($archivo);
            }

            $archivo = fopen("./archivos/alumnos.txt", "w");
            if ($archivo) {
                $cant = 0;
                foreach($elementosAux as $item){
                    $cant = fwrite($archivo, $item);
                }
                if($cant > 0)
                {
                    if ($borrado) {
                        echo 'El alumno con legajo ' . $legajo . ' se ha borrado'; 
                    } else {
                        echo 'El alumno con legajo ' . $legajo . ' no se ha borrado';
                    }
                } else {
                    echo 'Algo salio mal!';
                }
                fclose($archivo);
            }
            break;

        default:
            echo "Algo salio mal!";
            break;
    }
}

// PARTE 2
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch (strtolower($_GET["accion"])) {
        case 'listar':
            echo file_get_contents("./archivos/alumnos.txt");
            break;
        
        default:
            # code...
            break;
    }
}