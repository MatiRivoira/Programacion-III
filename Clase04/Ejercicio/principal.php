<?php
session_start();

// Verificar si las variables de sesión son válidas
if (isset($_SESSION['legajo']) && isset($_SESSION['nombre']) && isset($_SESSION['apellido']) && isset($_SESSION['foto'])) {
    $legajo = $_SESSION['legajo'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $foto = $_SESSION['foto'];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    </head>
    <body>
        <h1>Legajo: <?php echo $legajo; ?></h1>
        <h2>Nombre y Apellido: <?php echo $nombre . ' ' . $apellido; ?></h2>
        <img src="<?php echo $foto; ?>" alt="Foto del alumno">
        <table>
            <thead>
                <tr>
                    <th>Legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Cargar y mostrar la lista de alumnos desde el archivo
                $archivo = fopen("./archivos/alumnos_foto.txt", "r");
                if ($archivo) {
                    while (!feof($archivo)) {
                        $linea = fgets($archivo);
                        if (!empty(trim($linea))) {
                            $elemento = explode("-", $linea);
                            $legajo = trim($elemento[0]);
                            $nombre = trim($elemento[1]);
                            $apellido = trim($elemento[2]);
                            $foto = trim($elemento[3]);
                            echo "<tr>";
                            echo "<td>$legajo</td>";
                            echo "<td>$nombre</td>";
                            echo "<td>$apellido</td>";
                            echo "<td><img src='$foto' alt='Foto del alumno'></td>";
                            echo "</tr>";
                        }
                    }
                    fclose($archivo);
                }
                ?>
            </tbody>
        </table>
    </body>
    </html>
<?php
} else {
    // Variables de sesión no válidas, redirigir a ./nexo_poo_foto.php
    header('Location: ./nexo_poo_foto.php');
}
?>