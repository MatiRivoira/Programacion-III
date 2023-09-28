<?php
include_once "e22.php";

$garage = new Garage("Mi Garage", 10.50);

$auto1 = new Auto("Toyota", "Rojo", 20000);
$auto2 = new Auto("Ford", "Azul", 25000);
$auto3 = new Auto("Honda", "Gris", 30000);

$garage->Add($auto1);
echo "Autos en el Garage después de agregar auto1:<br>";
echo $garage->MostrarGarage();
echo "<br><br>";

$garage->Add($auto2);
echo "Autos en el Garage después de agregar auto2:<br>";
echo $garage->MostrarGarage();
echo "<br><br>";

$garage->Remove($auto1);
echo "Autos en el Garage después de quitar auto1:<br>";
echo $garage->MostrarGarage();
echo "<br><br>";

$garage->Add($auto3);
echo "Autos en el Garage después de agregar auto3:<br>";
echo $garage->MostrarGarage();