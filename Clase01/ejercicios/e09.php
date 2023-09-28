<?php

$array;
$contador = 0;
$promedio;

for ($i = 0; $i <= 5; $i++){
    $aux = rand(0, 10);
    $contador += $aux;
    $array[$i] = $aux;
}

$promedio = $contador / 5;

if ($promedio > 6) {
    echo "El promedio es mayor a 6" . "<br>";
} else if ($promedio == 6) {
    echo "El promedio es 6" . "<br>";
} else {
    echo "El promedio es menor a 6" . "<br>";
}

echo var_dump($array);