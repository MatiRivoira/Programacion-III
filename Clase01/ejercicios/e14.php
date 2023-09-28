<?php

$animales = [];
$años = [];
$lenguajes = [];

array_push($animales, 'Perro', 'Gato', 'Ratón', 'Araña', 'Mosca');
array_push($años, '1986', '1996', '2015', '78', '86');
array_push($lenguajes, 'php', 'mysql', 'html5', 'typescript', 'ajax');

$arrayAsociativo = array( "animales" => $animales, "años" => $años, "lenguajes" => $lenguajes);
$arrayIndexado = array($animales, $años, $lenguajes);

echo "Array asociativo <br>";
echo var_dump($arrayAsociativo) . "<br><br>";
echo "Array indexado <br>";
echo var_dump($arrayIndexado);


