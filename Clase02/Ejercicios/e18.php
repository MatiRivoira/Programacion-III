<?php

function EsPar(int $num) : int {
    if ($num % 2 == 0) {
        return true;
    }
    return false;
}

echo EsPar(2);