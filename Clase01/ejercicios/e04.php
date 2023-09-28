<?php
$suma = 0;

for ($i= 1; $suma < 1000; $i++) { 
    $suma += $i;
    if ($suma > 1000) {
        $suma = 1000;
    }
    echo $i . " - " . $suma . "<br>"; 
}
