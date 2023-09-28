<?php

function calcularPotencias($base) {
    for ($exponente = 1; $exponente <= 4; $exponente++) {
        $resultado = pow($base, $exponente);
        echo "Potencia de $base elevado a la $exponente es: $resultado<br>";
    }
}

for ($i = 1; $i <= 4; $i++) {
    calcularPotencias($i);
}