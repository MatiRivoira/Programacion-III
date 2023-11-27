<?php

include_once "./clases/Empleado.php";

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $empleados = Empleado::TraerTodos();
    if (isset($empleados)) {
        $html = '<h1>Listado de empleados</h1>';
        $html .= '<table>';
        $html .= '<thead>
                    <th>Id</th>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Id perfil</th>
                    <th>Sueldo</th>
                    <th>Foto</th>
                    </thead>';
        foreach ($empleados as $empleado) {
            var_dump($empleado);
            $html .= "<tr>
                      <td>$empleado->id</td>
                      <td>$empleado->correo</td>
                      <td>$empleado->nombre</td>
                      <td>$empleado->id_perfil</td>
                      <td>$empleado->sueldo</td>
                      <td><img src='$empleado->foto' alt='auto'></td>
                      </tr>";
        }
        echo $html;
    } else {
        echo json_encode($empleados);
    }
}