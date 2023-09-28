<?php

$animales = [];
$años = [];
$lenguajes = [];
$fusion = [];

array_push($animales, 'Perro', 'Gato', 'Ratón', 'Araña', 'Mosca');
array_push($años, '1986', '1996', '2015', '78', '86');
array_push($lenguajes, 'php', 'mysql', 'html5', 'typescript', 'ajax');

$fusion = array_merge($animales, $años, $lenguajes);

foreach ($fusion as $value) {
    echo $value . "<br>";
}