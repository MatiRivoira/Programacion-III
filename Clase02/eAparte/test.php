<?php
include_once "./clases/Mascota.php";
include_once "./clases/Guarderia.php";

use Animalitos\Mascota;
use Negocios\Guarderia;

$mascota1 = new Mascota("Pluto", "Perro");
$mascota2 = new Mascota("Pluto", "Gato");

echo "Mascotas 1,2 creadas: <br>";
echo $mascota1->toString() . "<br>";
echo Mascota::Mostrar($mascota2);

if ($mascota1->Equals($mascota2)) {
    echo "<br> las mascotas 1,2 son iguales";
} else {
    echo "<br> las mascotas 1,2 no son iguales";
}

$mascota3 = new Mascota("Tintin", "Perro", 6);
$mascota4 = new Mascota("Tintin", "Perro", 7);

echo "<br><br>Mascotas 3,4 creadas: <br>";
echo $mascota3->toString() . "<br>";
echo Mascota::Mostrar($mascota4);

if ($mascota3->Equals($mascota4)) {
    echo "<br> las mascotas 3,4 son iguales";
} else {
    echo "<br> las mascotas 3,4 no son iguales";
}

if ($mascota1->Equals($mascota3)) {
    echo "<br><br> la mascota 1 es igual a la 3";
} else {
    echo "<br><br> la mascota 1 no es igual a la 3";
}

echo "<h3> Segunda parte del ejercicio </h3>";

$guarderia = new Guarderia("La guarderia de Pancho");
echo "Guarderia creada";
if ($guarderia->Add($mascota1)) {
    echo "<br> Mascota 1 agregada correctamente a la guarderia";
} else {
    echo "<br> Mascota 1 no fue agregada correctamente a la guarderia";
}
if ($guarderia->Add($mascota2)) {
    echo "<br> Mascota 2 agregada correctamente a la guarderia";
} else {
    echo "<br> Mascota 2 no fue agregada correctamente a la guarderia";
}
if ($guarderia->Add($mascota3)) {
    echo "<br> Mascota 3 agregada correctamente a la guarderia";
} else {
    echo "<br> Mascota 3 no fue agregada correctamente a la guarderia";
}
if ($guarderia->Add($mascota4)) {
    echo "<br> Mascota 4 agregada correctamente a la guarderia";
} else {
    echo "<br> Mascota 4 no fue agregada correctamente a la guarderia";
}

echo "<br> Datos de la guarderia: <br>" . $guarderia->__toString();




