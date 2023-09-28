<?php
require_once "./clases/Alumno.php";
use Rivoira\Alumno;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
    $nombreFoto = $_POST['legajo'] . '.' . $extension;
    $destino = "./fotos/" . $nombreFoto;
    switch (strtolower($_POST["accion"])) {
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
            echo Alumno::LeerAF();
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
            if (Alumno::EstaXLegajo("./archivos/alumnos_foto.txt", $_POST['legajo'], "-")) {
                header("location: ./principal.php");
                exit;
            } else {
                echo "El alumno con legajo " . $_POST['legajo'] . "no se encuentra en el listado.";
            }
        break;
    }
}