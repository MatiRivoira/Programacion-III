<?php
require_once "./clases/Alumno.php";
require_once __DIR__ . '/vendor/autoload.php';
use Rivoira\Alumno;

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['accion'])) {
    if (isset($_GET['accion'])) {
        $accion = $_GET['accion'];
    } else {
        $accion = $_POST['accion'];
        $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $nombreFoto = $_POST['legajo'] . '.' . $extension;
        $destino = "./fotos/" . $nombreFoto;
    }
    switch ($accion) {
        case 'agregar':
            if (Alumno::AgregarAF(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido'], $destino)) && move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
                echo "Alumno agregado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'borrar':
            if (Alumno::EliminarAF(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido']))) {
                echo "Alumno borrado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'modificar':
            if (Alumno::ModificarAF(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido'], $destino)) && move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
                echo "Alumno modificado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'listar':
            echo "<h1>".Alumno::LeerAF()."</h1>";
            break;
            
        case 'obtener':
            $alumno = Alumno::BuscarXLegajoAF($_POST['legajo']);
            if ($alumno !== null) {
                var_dump($alumno);
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'redirigir':
            $alumno = Alumno::BuscarXLegajoAF($_POST['legajo']);
            if ($alumno !== null) {
                session_start();
                $datos = explode("-", $alumno->__toString());
                $_SESSION["legajo"] = $datos[0];
                $_SESSION["nombre"] = $datos[1];
                $_SESSION["apellido"] = $datos[2];
                $_SESSION["foto"] = $datos[3];
                header("location: ./principal.php");
            } else {
                echo "El alumno con legajo " . $_POST['legajo'] . " no se encuentra en el listado.";
                header('Refresh: 3; URL=./index.html');
            }
        break;

        case 'listarPDF':
            header('content-type:application/pdf');
            $mpdf = new \Mpdf\Mpdf();
            $html = '<h1>Listado de Alumnos</h1>';
            $html .= '<table>';
            $html .= '<thead>
                        <th>Legajo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Foto</th>
                      </thead>';
        
            $archivo = fopen("./archivos/alumnos_foto.txt", "r");
            if ($archivo) {
                while (!feof($archivo)) {
                    $linea = fgets($archivo);
                    if (!empty(trim($linea))) {
                        $valores = explode("-", $linea);
                        $legajo = trim($valores[0]);
                        $nombre = trim($valores[1]);
                        $apellido = trim($valores[2]);
                        $pathFoto = trim($valores[3]);
        
                        $html .= "<tr>
                                    <td>$legajo</td>
                                    <td>$nombre</td>
                                    <td>$apellido</td>
                                    <td><img src='$pathFoto' alt='Foto del alumno'></td>
                                  </tr>";
                    }
                }
                fclose($archivo);
            }
            $html .= '</table>';
            $mpdf->WriteHTML($html);
            $mpdf->Output();
    }
}