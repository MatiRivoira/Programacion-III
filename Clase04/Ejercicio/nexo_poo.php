<?php
require_once "./clases/Alumno.php";
use Rivoira\Alumno;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (strtolower($_POST["accion"])) {
        case 'agregar':
            if (Alumno::Agregar(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido']))) {
                echo "Alumno agregado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'borrar':
            if (Alumno::Eliminar(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido']))) {
                echo "Alumno borrado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'modificar':
            if (Alumno::Modificar(new Alumno($_POST['legajo'], $_POST['nombre'], $_POST['apellido']))) {
                echo "Alumno modificado correctamente";
            } else {
                echo "Algo salio mal! :c";
            }
            break;
        case 'listar':
            echo Alumno::Leer();
            break;
    }
}