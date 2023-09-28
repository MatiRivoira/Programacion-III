<?php
include_once "e21.php";

$auto1 = new Auto("McLaren", "verde");
$auto2 = new Auto("McLaren", "naranja");

$auto3 = new Auto("Ferrari", "rojo", 500000);
$auto4 = new Auto("Ferrari", "marron", 250000);

$auto5 = new Auto("Porsche", "verde lima", 200000, new DateTime('2023-09-06'));

$auto3->AgregarImpuestos(1500);
$auto4->AgregarImpuestos(1500);
$auto5->AgregarImpuestos(1500);

echo "importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado
obtenido. <br><br>";
echo Auto::Add($auto1, $auto2);

echo "<br><br>Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no. <br><br>";
echo Auto::Equals($auto2, $auto5);

echo "<br><br>Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5) <br><br>";
echo "Auto N°1: <br>" . Auto::MostrarAuto($auto1).
     "<br><br>Auto N°3: <br>" . Auto::MostrarAuto($auto3).
     "<br><br>Auto N°5: <br>" . Auto::MostrarAuto($auto5);

