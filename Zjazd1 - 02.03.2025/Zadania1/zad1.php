<?php

$arr = array("jabłko", "banan", "pomarancza", "Panini");

foreach ($arr as $value) {
    if ($value[0] == 'p' || $value[0] == 'P') {
        $value2 = "";
        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $value2 .= $value[$i];
        }

        echo $value2 . "\n" ;
    }
}