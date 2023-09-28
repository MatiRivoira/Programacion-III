<?php

$dia = date("j");
$mes = date("n");

switch (1) {
    case 1:
        echo date("d/m/Y");
        break;
    case 2:
        echo date("D-M-Y");
        break;
    case 3:
        echo date("Y/m/d");
        break;
}

switch ($mes) {
    case 12:
        if ($dia <= 21) {
            $estacion = "Primavera";
        } else {
            $estacion = "Verano";
        }
        break;
    case 1:
    case 2:
        $estacion = "Verano";
        break;

    case 3:
        if ($dia >= 21) {
            $estacion = "Otoño";
        } else {
            $estacion = "Verano";
        }
        break;
    case 4:
    case 5:
        $estacion = "Otoño";
        break;
    case 6:
        if ($dia >= 21) {
            $estacion = "Invierno";
        } else {
            $estacion = "Otoño";
        }
        break;
    case 7:
    case 8:
        $estacion = "Invierno";
        break;
    case 9:
        if ($dia >= 21) {
            $estacion = "Primavera";
        } else {
            $estacion = "Invierno";
        }
        break;
    case 10:
    case 11:
        $estacion = "Otoño";
        break;
    default:
        $estacion = "Desconocida";
        break;
}

echo "</br>" . $estacion;