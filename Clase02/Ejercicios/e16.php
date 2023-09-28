<?php

function DarVuelta(array $array) : array {
    return array_reverse($array);
}

$array = ["H", "O", "L", "A"];

var_dump($array);
echo "<br>";
var_dump(DarVuelta($array));