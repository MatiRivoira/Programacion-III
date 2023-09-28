<?php
include_once "e23.php";

$vuelo = new Vuelo("Aerolínea XYZ", 500, 100);

$pasajero1 = new Pasajero("Gómez", "Juan", "12345678", false);
$pasajero2 = new Pasajero("López", "Ana", "87654321", true);

echo "Agregando pasajero 1 al vuelo:<br>";
if ($vuelo->AgregarPasajero($pasajero1)) {
    echo "Pasajero agregado al vuelo.<br>";
} else {
    echo "No se pudo agregar el pasajero al vuelo.<br>";
}

echo "Agregando pasajero 2 al vuelo:<br>";
if ($vuelo->AgregarPasajero($pasajero2)) {
    echo "Pasajero agregado al vuelo.<br>";
} else {
    echo "No se pudo agregar el pasajero al vuelo.<br>";
}

echo "Información del Vuelo:<br>";
$vuelo->MostrarVuelo();

echo "Eliminando pasajero 1 del vuelo";