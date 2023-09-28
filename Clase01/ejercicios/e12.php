<?php

$lapicera = [ 'color' => '', 'marca' => '', 'trazo' => '', 'precio' => 0, ];

$lapiceras = array();

$lapicera['color'] = 'azul';
$lapicera['marca'] = 'Bic';
$lapicera['trazo'] = 'fino';
$lapicera['precio'] = 1.5;
$lapiceras[] = $lapicera;

$lapicera['color'] = 'negro';
$lapicera['marca'] = 'Bic';
$lapicera['trazo'] = 'grueso';
$lapicera['precio'] = 2.0;
$lapiceras[] = $lapicera; 

$lapicera['color'] = 'rojo';
$lapicera['marca'] = 'Bic';
$lapicera['trazo'] = 'grueso';
$lapicera['precio'] = 2.5;
$lapiceras[] = $lapicera; 

foreach ($lapiceras as $index => $lapicera) {
    echo "<br> Lapicera $index: <br>";
    echo "Color: " . $lapicera['color'] . "<br/>";
    echo "Marca: " . $lapicera['marca'] . "<br/>";
    echo "Trazo: " . $lapicera['trazo'] . "<br/>";
    echo "Precio: $" . $lapicera['precio'] . "<br/>";
}
