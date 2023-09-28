<?php

function ValidarMax(string $palabra, int $max) : int {
    if (strlen($palabra) <= $max) {
        switch ($palabra) {
            case 'Recuperatorio':
            case 'Parcial':
            case 'Programacion':
                return 1;
                break;
        }
    }
    return 0;
}

echo ValidarMax("Recuperatorio", 100);
echo "<br>" . ValidarMax("Parcial", 100);
echo "<br>" . ValidarMax("Programacion", 100);