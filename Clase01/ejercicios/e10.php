<?php

$numerosImpares = [];

for ($i = 1; count($numerosImpares) < 10; $i++) { 
    if ($i % 2 != 0) {
        $numerosImpares[] += $i;
    }
}

for ($i = 0; $i < count($numerosImpares); $i++) { 
    echo $numerosImpares[$i] . "<br>";
}

$aux = 0;
while ($aux < count($numerosImpares)) {
    echo $numerosImpares[$aux] . "<br>";
    $aux++;
}

foreach ($numerosImpares as $num) {
    echo $num . "<br>";
}