<?php
$a = 1;
$b = 0;
$c = 2;

$max = max($a, $b, $c);
$min = min($a, $b, $c);

if ($a < $max && $a > $min) {
    echo "el valor del medio es: $a";   
} else if ($b < $max && $b > $min) {
    echo "el valor del medio es: $b";   
} else if ($c < $max && $c > $min) {
    echo "el valor del medio es: $c";   
} else {
    echo "No hay valor medio";
}


