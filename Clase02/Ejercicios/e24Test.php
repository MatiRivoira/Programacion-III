<?php
include_once "e24.php";

$operario1 = new Operario(101, "Perez", "Juan", 5000);
$operario2 = new Operario(102, "Gomez", "Ana", 6000);
$operario3 = new Operario(103, "Lopez", "Carlos", 5500);

$fabrica = new Fabrica("IDK");
$fabrica->Add($operario1);
$fabrica->Add($operario2);
$fabrica->Add($operario3);

echo $fabrica->Mostrar() . "<br>";

echo $operario1->Mostrar() . "<br>";
echo $operario2->Mostrar() . "<br>";
echo $fabrica::MostrarCosto($fabrica) . "\n";

echo $fabrica->Remove($operario1);

echo "Después de quitar a Juan Perez:\n";
echo $fabrica->Mostrar();